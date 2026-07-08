<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['member', 'membership'])
            ->latest()
            ->get();

        if (request()->is('api/*')) {
            return response()->json($payments);
        }

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['member', 'membership']);

        if (request()->is('api/*')) {
            return response()->json($payment);
        }

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $payment->load(['member', 'membership']);

        $memberships = Membership::with('member')
            ->where('member_id', $payment->member_id)
            ->get();

        return view('payments.edit', compact('payment', 'memberships'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'payment_method' => 'required|in:cash,online',
            'status' => 'required|in:pending,paid,failed',
            'payment_date' => 'required|date',
        ]);

        $membership = Membership::findOrFail($request->membership_id);

        $paymentMethod = $request->payment_method;
        $status = $request->status;

        if (
            strtolower($payment->payment_method) === 'online' ||
            strtolower($payment->payment_method) === 'online payment'
        ) {
            $paymentMethod = 'online';
            $status = 'paid';
        }

        $payment->update([
            'member_id' => $membership->member_id,
            'membership_id' => $membership->id,
            'amount' => $membership->price,
            'payment_method' => $paymentMethod,
            'status' => $status,
            'payment_date' => $request->payment_date,
        ]);

        if ($status === 'paid') {
            $membership->update([
                'status' => 'active',
            ]);
        } elseif ($status === 'failed') {
            $membership->update([
                'status' => 'failed',
            ]);
        } else {
            $membership->update([
                'status' => 'pending',
            ]);
        }

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Payment updated successfully.',
                'data' => $payment->load(['member', 'membership']),
            ]);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Payment deleted successfully.',
            ]);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}