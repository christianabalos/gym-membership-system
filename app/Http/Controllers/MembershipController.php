<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Trainer;
use App\Models\Payment;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    private function scheduleSlots()
    {
        return [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM',
        ];
    }

    public function index()
    {
        $memberships = Membership::with(['member', 'trainer'])
            ->latest()
            ->get();

        return view('memberships.index', compact('memberships'));
    }

    public function create()
    {
        $members = Member::all();

        $trainers = Trainer::with(['memberships' => function ($query) {
            $query->whereIn('status', ['pending', 'active']);
        }])->get();

        $scheduleSlots = $this->scheduleSlots();

        return view('memberships.create', compact('members', 'trainers', 'scheduleSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'schedule_time' => 'nullable|string',
            'plan_name' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'payment_method' => 'required|in:cash,online',
        ]);

        $overlap = Membership::where('member_id', $request->member_id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                    ->where('end_date', '>', $request->start_date);
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_date' => 'This member already has a membership within the selected date range.',
                ]);
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

        $membership = Membership::create([
            'member_id' => $request->member_id,
            'trainer_id' => $request->trainer_id,
            'schedule_time' => $request->trainer_id ? $request->schedule_time : null,
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        Payment::create([
            'member_id' => $request->member_id,
            'membership_id' => $membership->id,
            'amount' => $request->price,
            'payment_date' => now()->toDateString(),
            'payment_method' => $request->payment_method,
            'status' => $request->status === 'active' ? 'paid' : 'pending',
        ]);

        return redirect()->route('memberships.index')
            ->with('success', 'Membership created successfully.');
    }

    public function show(Membership $membership)
    {
        $membership->load(['member', 'trainer']);

        return view('memberships.show', compact('membership'));
    }

    public function edit(Membership $membership)
    {
        $members = Member::all();

        $trainers = Trainer::with(['memberships' => function ($query) use ($membership) {
            $query->whereIn('status', ['pending', 'active'])
                ->where('id', '!=', $membership->id);
        }])->get();

        $scheduleSlots = $this->scheduleSlots();

        return view('memberships.edit', compact('membership', 'members', 'trainers', 'scheduleSlots'));
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'schedule_time' => 'nullable|string',
            'plan_name' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        $overlap = Membership::where('member_id', $request->member_id)
            ->where('id', '!=', $membership->id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                    ->where('end_date', '>', $request->start_date);
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_date' => 'This member already has a membership within the selected date range.',
                ]);
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
                ->where('id', '!=', $membership->id)
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
                ->where('id', '!=', $membership->id)
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

        $membership->update([
            'member_id' => $request->member_id,
            'trainer_id' => $request->trainer_id,
            'schedule_time' => $request->trainer_id ? $request->schedule_time : null,
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        $payment = Payment::where('membership_id', $membership->id)->first();

        if ($payment) {
            $payment->update([
                'member_id' => $request->member_id,
                'amount' => $request->price,
                'status' => $request->status === 'active' ? 'paid' : 'pending',
            ]);
        }

        return redirect()->route('memberships.index')
            ->with('success', 'Membership updated successfully.');
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();

        return redirect()->route('memberships.index')
            ->with('success', 'Membership deleted successfully.');
    }
}