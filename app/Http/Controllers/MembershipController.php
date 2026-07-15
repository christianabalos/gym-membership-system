<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Trainer;
use App\Models\Payment;
use App\Models\Workout;
use App\Services\WorkoutScheduleGenerator;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::with(['member', 'trainer'])
            ->latest()
            ->get();

        return view('memberships.index', compact('memberships'));
    }

    public function create()
    {
        $members = Member::with('memberships')
            ->orderBy('full_name')
            ->get();

        $trainers = Trainer::orderBy('name')->get();

        return view('memberships.create', compact('members', 'trainers'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'price' => preg_replace('/[^0-9.]/', '', $request->price),
            'payment_method' => strtolower($request->payment_method),
        ]);

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'plan_name' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,active,approved,cancelled',
            'payment_method' => 'required|in:cash,online',
            'schedule_time' => 'nullable|string',
        ]);

        $overlap = Membership::where('member_id', $request->member_id)
            ->whereIn('status', ['pending', 'active', 'approved'])
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

        $membership = Membership::create([
            'member_id' => $request->member_id,
            'trainer_id' => $request->trainer_id,
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'schedule_time' => $request->schedule_time,
        ]);

        $paymentStatus = match ($request->status) {
            'active', 'approved' => 'paid',
            'cancelled' => 'cancelled',
            default => 'pending',
        };

        Payment::create([
            'member_id' => $request->member_id,
            'membership_id' => $membership->id,
            'amount' => $request->price,
            'payment_date' => now()->toDateString(),
            'payment_method' => $request->payment_method,
            'status' => $paymentStatus,
        ]);

        if (in_array($request->status, ['active', 'approved']) && $request->trainer_id && $request->schedule_time) {
            $membership->load(['member', 'trainer']);

            app(WorkoutScheduleGenerator::class)->generateNextWeek($membership);
        }

        return redirect()
            ->route('memberships.index')
            ->with('success', 'Membership created successfully.');
    }

    public function show(Membership $membership)
    {
        $membership->load(['member', 'trainer']);

        return view('memberships.show', compact('membership'));
    }

    public function edit(Membership $membership)
    {
        $membership->load(['member', 'trainer']);

        $members = Member::orderBy('full_name')->get();
        $trainers = Trainer::orderBy('name')->get();

        $firstMembership = Membership::where('member_id', $membership->member_id)
            ->orderBy('start_date')
            ->orderBy('id')
            ->first();

        $isFirstMembership = $firstMembership && $firstMembership->id === $membership->id;

        $scheduleSlots = [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM',
        ];

        $trainerBookings = Membership::whereNotNull('trainer_id')
            ->whereNotNull('schedule_time')
            ->where('id', '!=', $membership->id)
            ->whereIn('status', ['pending', 'active', 'approved'])
            ->get([
                'id',
                'trainer_id',
                'schedule_time',
                'start_date',
                'end_date',
                'member_id',
                'status',
            ]);

        return view('memberships.edit', compact(
            'membership',
            'members',
            'trainers',
            'scheduleSlots',
            'trainerBookings',
            'isFirstMembership'
        ));
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'plan_name' => 'required|in:Monthly,Quarterly,Annual',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,active,approved,cancelled',
            'schedule_time' => 'nullable|string',
        ]);

        $trainerId = $request->trainer_id;
        $scheduleTime = $request->schedule_time;

        $membership->update([
            'member_id' => $request->member_id,
            'trainer_id' => $trainerId,
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'schedule_time' => $scheduleTime,
        ]);

        $paymentStatus = match ($request->status) {
            'active', 'approved' => 'paid',
            'pending' => 'pending',
            'cancelled' => 'cancelled',
            default => 'pending',
        };

        Payment::where('membership_id', $membership->id)->update([
            'member_id' => $request->member_id,
            'amount' => $request->price,
            'status' => $paymentStatus,
        ]);

        if ($request->status === 'cancelled' || $request->status === 'pending') {
            Workout::where('membership_id', $membership->id)->delete();

            return redirect()
                ->route('memberships.index')
                ->with('success', 'Membership updated. Workouts removed because status is not approved.');
        }

        if (in_array($request->status, ['active', 'approved'])) {
            Workout::where('membership_id', $membership->id)->delete();

            if ($trainerId && $scheduleTime) {
                $membership->refresh();
                $membership->load(['member', 'trainer']);

                app(WorkoutScheduleGenerator::class)->generateNextWeek($membership);
            }
        }

        return redirect()
            ->route('memberships.index')
            ->with('success', 'Membership updated successfully.');
    }

    public function destroy(Membership $membership)
    {
        Payment::where('membership_id', $membership->id)->delete();

        Workout::where('membership_id', $membership->id)->delete();

        $membership->delete();

        return redirect()
            ->route('memberships.index')
            ->with('success', 'Membership deleted successfully.');
    }
}