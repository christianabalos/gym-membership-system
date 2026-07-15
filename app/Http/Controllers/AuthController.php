<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Payment;
use App\Services\WorkoutScheduleGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        $trainers = Trainer::with(['memberships' => function ($query) {
            $query->whereIn('status', ['pending', 'active', 'approved']);
        }])->orderBy('name')->get();

        return view('auth.register', compact('trainers'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birth_month' => 'required',
            'birth_day' => 'required',
            'birth_year' => 'required',
            'gender' => 'required',
            'trainer_id' => 'nullable|exists:trainers,id',
            'schedule_time' => 'nullable|string',
            'plan_name' => 'required|in:Monthly,Quarterly,Annual',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'payment_method' => 'required|in:cash,online',
        ]);

        if ($request->trainer_id && !$request->schedule_time) {
            return back()
                ->withInput()
                ->withErrors([
                    'schedule_time' => 'Please choose an available schedule time.',
                ]);
        }

        if ($request->trainer_id && $request->schedule_time) {
            $trainerBookedCount = Membership::where('trainer_id', $request->trainer_id)
                ->whereIn('status', ['pending', 'active', 'approved'])
                ->whereNotNull('schedule_time')
                ->distinct('schedule_time')
                ->count('schedule_time');

            if ($trainerBookedCount >= 6) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'trainer_id' => 'This trainer is fully booked. Please choose another trainer.',
                    ]);
            }

            $slotTaken = Membership::where('trainer_id', $request->trainer_id)
                ->where('schedule_time', $request->schedule_time)
                ->whereIn('status', ['pending', 'active', 'approved'])
                ->exists();

            if ($slotTaken) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'schedule_time' => 'This schedule time is already booked. Please choose another time.',
                    ]);
            }
        }

        DB::beginTransaction();

        try {
            $basePrices = [
                'Monthly' => 500,
                'Quarterly' => 1800,
                'Annual' => 5500,
            ];

            $basePrice = $basePrices[$request->plan_name];
            $trainerFee = $request->trainer_id ? 300 : 0;
            $totalPrice = $basePrice + $trainerFee;

            $birthDate = $request->birth_year . '-' .
                str_pad($request->birth_month, 2, '0', STR_PAD_LEFT) . '-' .
                str_pad($request->birth_day, 2, '0', STR_PAD_LEFT);

            $membershipStatus = $request->payment_method === 'online'
                ? 'approved'
                : 'pending';

            $paymentStatus = $request->payment_method === 'online'
                ? 'paid'
                : 'pending';

            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);

            $member = Member::create([
                'user_id' => $user->id,
                'trainer_id' => $request->trainer_id,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'birth_date' => $birthDate,
                'gender' => $request->gender,
            ]);

            $membership = Membership::create([
                'member_id' => $member->id,
                'trainer_id' => $request->trainer_id,
                'schedule_time' => $request->trainer_id ? $request->schedule_time : null,
                'plan_name' => $request->plan_name,
                'price' => $totalPrice,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $membershipStatus,
            ]);

            $payment = Payment::create([
                'member_id' => $member->id,
                'membership_id' => $membership->id,
                'amount' => $totalPrice,
                'payment_date' => now()->toDateString(),
                'payment_method' => $request->payment_method,
                'status' => $paymentStatus,
            ]);

            if ($membershipStatus === 'approved' && $membership->trainer_id && $membership->schedule_time) {
                $membership->load(['member', 'trainer']);

                app(WorkoutScheduleGenerator::class)->generateNextWeek($membership);
            }

            DB::commit();

            Auth::login($user);

            if ($request->payment_method === 'online') {
                return $this->createPayMongoCheckout($payment);
            }

            return redirect()->route('member.dashboard')
                ->with('success', 'Registration successful. Your cash payment is pending admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors([
                    'register' => 'Registration failed. Please try again. Error: ' . $e->getMessage(),
                ])
                ->withInput();
        }
    }

    private function createPayMongoCheckout(Payment $payment)
    {
        $payment->load('membership');

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
                    'payment' => 'Online payment checkout failed. Your membership is already approved and workouts were generated.',
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
            ->with('success', 'Registration successful. Your online payment membership is approved and workouts were generated.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            }

            return redirect()->route('member.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}