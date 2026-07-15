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
            ->whereIn('status', ['active', 'approved'])
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

        $trainers = Trainer::orderBy('name')->get();

        $latestMembership = Membership::where('member_id', $member->id)
            ->whereIn('status', ['pending', 'active', 'approved'])
            ->orderBy('end_date', 'desc')
            ->first();

        $nextStartDate = $latestMembership ? $latestMembership->end_date : null;

        return view('member.register-membership', compact(
            'member',
            'trainers',
            'nextStartDate'
        ));
    }

    public function storeMembership(Request $request)
    {
        $request->validate([
            'trainer_id' => 'nullable|exists:trainers,id',
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
            ->whereIn('status', ['pending', 'active', 'approved'])
            ->orderBy('end_date', 'desc')
            ->first();

        if ($existingMembership) {
            $newStartDate = Carbon::parse($request->start_date)->startOfDay();
            $existingEndDate = Carbon::parse($existingMembership->end_date)->startOfDay();

            if ($newStartDate->lt($existingEndDate)) {
                return back()
                    ->withErrors([
                        'start_date' => 'Your current membership ends on ' . $existingEndDate->format('Y-m-d') . '. Please choose ' . $existingEndDate->format('Y-m-d') . ' or later as your start date.',
                    ])
                    ->withInput();
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

        $paymentMethod = strtolower($request->payment_method);

        $membership = Membership::create([
            'member_id' => $member->id,
            'trainer_id' => $request->trainer_id,
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
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'payment_date' => now()->toDateString(),
        ]);

        if ($paymentMethod === 'online') {
            return $this->createPayMongoCheckout($payment);
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Membership request submitted. Waiting for admin approval.');
    }

    private function createPayMongoCheckout(Payment $payment)
{
    $payment->load(['membership.member.user']);

    $secretKey = env('PAYMONGO_SECRET_KEY');

    if (!$secretKey) {
        return redirect()->route('member.dashboard')
            ->withErrors([
                'payment' => 'PayMongo secret key is missing in .env.',
            ]);
    }

    $successUrl = env('PAYMONGO_SUCCESS_URL', url('/paymongo/success'));
    $cancelUrl = env('PAYMONGO_CANCEL_URL', url('/paymongo/cancel'));

    $memberName = $payment->membership->member->full_name ?? 'Gym Member';
    $memberEmail = $payment->membership->member->user->email ?? 'member@example.com';

    $amount = (int) round($payment->amount * 100);

    $response = Http::withBasicAuth($secretKey, '')
        ->acceptJson()
        ->asJson()
        ->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => $amount,
                            'name' => $payment->membership->plan_name . ' Membership',
                            'quantity' => 1,
                        ],
                    ],

                    'payment_method_types' => [
                        'gcash',
                    ],

                    'billing' => [
                        'name' => $memberName,
                        'email' => $memberEmail,
                    ],

                    'description' => 'Gym Membership Payment',
                    'success_url' => $successUrl . '?payment_id=' . $payment->id,
                    'cancel_url' => $cancelUrl . '?payment_id=' . $payment->id,
                ],
            ],
        ]);

    if ($response->failed()) {
        return redirect()->route('member.dashboard')
            ->withErrors([
                'payment' => 'PayMongo checkout failed: ' . $response->body(),
            ]);
    }

    $checkout = $response->json();

    $checkoutId = $checkout['data']['id'] ?? null;
    $checkoutUrl = $checkout['data']['attributes']['checkout_url'] ?? null;

    if (!$checkoutUrl) {
        return redirect()->route('member.dashboard')
            ->withErrors([
                'payment' => 'No checkout URL received from PayMongo.',
            ]);
    }

    $payment->update([
        'paymongo_checkout_id' => $checkoutId,
        'paymongo_checkout_url' => $checkoutUrl,
    ]);

    return redirect()->away($checkoutUrl);
}

    public function paymongoSuccess(Request $request)
    {
        $payment = Payment::with('membership')->find($request->payment_id);

        if (!$payment) {
            return redirect()->route('member.dashboard')
                ->withErrors([
                    'payment' => 'Payment record not found.',
                ]);
        }

        $payment->update([
            'status' => 'paid',
            'payment_date' => now()->toDateString(),
        ]);

        if ($payment->membership) {
            $payment->membership->update([
                'status' => 'approved',
            ]);
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Online payment successful. Your membership is now approved.');
    }

    public function paymongoCancel(Request $request)
    {
        return redirect()->route('member.dashboard')
            ->withErrors([
                'payment' => 'Online payment was cancelled. Your membership is still pending.',
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