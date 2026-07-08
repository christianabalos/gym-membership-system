<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Workout;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $member = Member::where('user_id', auth()->id())->first();

        if (!$member) {
            return redirect()->route('welcome')
                ->withErrors([
                    'member' => 'Member profile not found.',
                ]);
        }

        $activeMembership = Membership::where('member_id', $member->id)
            ->where('status', 'active')
            ->orderBy('end_date', 'desc')
            ->first();

        $pendingMembership = Membership::where('member_id', $member->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->first();

        $daysLeft = null;

        if ($activeMembership && $activeMembership->end_date) {
            $daysLeft = now()->startOfDay()
                ->diffInDays(Carbon::parse($activeMembership->end_date)->startOfDay(), false);
        }

        return view('member.dashboard', compact(
            'member',
            'activeMembership',
            'pendingMembership',
            'daysLeft'
        ));
    }

    public function registerMembership()
    {
        $member = Member::where('user_id', auth()->id())->first();

        if (!$member) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'member' => 'Member profile not found.',
                ]);
        }

        $member->load('trainer');

        $trainers = Trainer::with(['memberships' => function ($query) {
            $query->whereIn('status', ['pending', 'active']);
        }])->orderBy('name')->get();

        $scheduleSlots = [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM',
        ];

        $latestMembership = Membership::where('member_id', $member->id)
            ->whereIn('status', ['pending', 'active'])
            ->orderBy('end_date', 'desc')
            ->first();

        $nextStartDate = $latestMembership ? $latestMembership->end_date : null;

        return view('member.register-membership', compact(
            'member',
            'trainers',
            'scheduleSlots',
            'nextStartDate'
        ));
    }

    public function storeMembership(Request $request)
    {
        $request->validate([
            'trainer_id' => 'nullable|exists:trainers,id',
            'schedule_time' => 'nullable|string',
            'plan_name' => 'required|in:Monthly,Quarterly,Annual',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_method' => 'required|in:cash,online',
        ]);

        $member = Member::where('user_id', auth()->id())->first();

        if (!$member) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'member' => 'Member profile not found.',
                ]);
        }

        $existingMembership = Membership::where('member_id', $member->id)
            ->whereIn('status', ['pending', 'active'])
            ->orderBy('end_date', 'desc')
            ->first();

        if ($existingMembership) {
            $newStartDate = Carbon::parse($request->start_date);
            $existingEndDate = Carbon::parse($existingMembership->end_date);

            if ($newStartDate->lt($existingEndDate)) {
                return back()
                    ->withErrors([
                        'start_date' => 'Your current membership ends on ' . $existingEndDate->format('Y-m-d') . '. Please choose ' . $existingEndDate->format('Y-m-d') . ' or later as your start date.',
                    ])
                    ->withInput();
            }
        }

        $maxSlots = 6;

        if ($request->trainer_id) {
            if (!$request->schedule_time) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'schedule_time' => 'Please choose a schedule time.',
                    ]);
            }

            $trainerBookedCount = Membership::where('trainer_id', $request->trainer_id)
                ->whereIn('status', ['pending', 'active'])
                ->whereNotNull('schedule_time')
                ->distinct('schedule_time')
                ->count('schedule_time');

            if ($trainerBookedCount >= $maxSlots) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'trainer_id' => 'This trainer is fully booked. Please choose another trainer.',
                    ]);
            }

            $slotTaken = Membership::where('trainer_id', $request->trainer_id)
                ->where('schedule_time', $request->schedule_time)
                ->whereIn('status', ['pending', 'active'])
                ->exists();

            if ($slotTaken) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'schedule_time' => 'This schedule time is already taken. Please choose another time.',
                    ]);
            }
        }

        $basePrices = [
            'Monthly' => 500,
            'Quarterly' => 1800,
            'Annual' => 5500,
        ];

        $basePrice = $basePrices[$request->plan_name];
        $trainerFee = $request->trainer_id ? 300 : 0;
        $totalPrice = $basePrice + $trainerFee;

        $membership = Membership::create([
            'member_id' => $member->id,
            'trainer_id' => $request->trainer_id,
            'schedule_time' => $request->trainer_id ? $request->schedule_time : null,
            'plan_name' => $request->plan_name,
            'price' => $totalPrice,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        $payment = Payment::create([
            'member_id' => $member->id,
            'membership_id' => $membership->id,
            'amount' => $membership->price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_date' => now()->toDateString(),
        ]);

        if ($request->payment_method === 'online') {
            return $this->createPayMongoCheckout($payment);
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Membership request submitted. Please wait for admin approval.');
    }

    private function createPayMongoCheckout(Payment $payment)
    {
        $successUrl = config('services.paymongo.success_url', env('PAYMONGO_SUCCESS_URL'));
        $cancelUrl = config('services.paymongo.cancel_url', env('PAYMONGO_CANCEL_URL'));

        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => false,
                        'show_description' => true,
                        'show_line_items' => true,
                        'cancel_url' => $cancelUrl . '?payment_id=' . $payment->id,
                        'success_url' => $successUrl . '?payment_id=' . $payment->id,
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $payment->amount * 100,
                                'description' => 'Gym Membership Payment',
                                'name' => $payment->membership->plan_name . ' Membership',
                                'quantity' => 1,
                            ],
                        ],
                        'payment_method_types' => [
                            'gcash',
                            'paymaya',
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'payment' => 'Online payment checkout failed. Please try again.',
                ]);
        }

        $checkout = $response->json();

        $checkoutId = $checkout['data']['id'] ?? null;
        $checkoutUrl = $checkout['data']['attributes']['checkout_url'] ?? null;

        $payment->update([
            'paymongo_checkout_id' => $checkoutId,
            'paymongo_checkout_url' => $checkoutUrl,
        ]);

        if ($checkoutUrl) {
            return redirect($checkoutUrl);
        }

        return redirect()->route('member.dashboard')
            ->withErrors([
                'payment' => 'No checkout URL received from PayMongo.',
            ]);
    }

    public function schedules()
    {
        $member = Member::where('user_id', auth()->id())->first();

        if (!$member) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'member' => 'Member profile not found.',
                ]);
        }

        $workouts = Workout::with('trainer')
            ->where('member_id', $member->id)
            ->orderBy('workout_date')
            ->get();

        return view('member.schedules', compact('member', 'workouts'));
    }

    public function payments()
    {
        $member = Member::where('user_id', auth()->id())->first();

        if (!$member) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'member' => 'Member profile not found.',
                ]);
        }

        $payments = Payment::with('membership')
            ->where('member_id', $member->id)
            ->latest()
            ->get();

        return view('member.payments', compact('member', 'payments'));
    }
}