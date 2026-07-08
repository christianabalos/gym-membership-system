<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Services\WorkoutScheduleGenerator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    private function getWorkoutTimeFromMembership(Membership $membership): string
    {
        if ($membership->schedule_time) {
            return $membership->schedule_time;
        }

        return '8:00 AM - 9:00 AM';
    }

    private function normalizeWorkoutTime($time)
    {
        $time = trim($time ?? '');

        $map = [
            '8:00 AM' => '8:00 AM - 9:00 AM',
            '08:00 AM' => '8:00 AM - 9:00 AM',
            '8 AM' => '8:00 AM - 9:00 AM',

            '9:00 AM' => '9:00 AM - 10:00 AM',
            '09:00 AM' => '9:00 AM - 10:00 AM',
            '9 AM' => '9:00 AM - 10:00 AM',

            '10:00 AM' => '10:00 AM - 11:00 AM',
            '10 AM' => '10:00 AM - 11:00 AM',

            '1:00 PM' => '1:00 PM - 2:00 PM',
            '01:00 PM' => '1:00 PM - 2:00 PM',
            '1 PM' => '1:00 PM - 2:00 PM',

            '2:00 PM' => '2:00 PM - 3:00 PM',
            '02:00 PM' => '2:00 PM - 3:00 PM',
            '2 PM' => '2:00 PM - 3:00 PM',

            '4:00 PM' => '4:00 PM - 5:00 PM',
            '04:00 PM' => '4:00 PM - 5:00 PM',
            '4 PM' => '4:00 PM - 5:00 PM',
        ];

        return $map[$time] ?? $time;
    }

    public function index()
    {
        $workouts = Workout::with(['member', 'trainer'])
            ->orderBy('member_id')
            ->orderBy('workout_date')
            ->get()
            ->groupBy('member_id');

        if (request()->is('api/*')) {
            return response()->json($workouts);
        }

        $memberships = Membership::with(['member', 'trainer'])
            ->whereIn('status', ['active', 'approved'])
            ->whereNotNull('trainer_id')
            ->orderBy('member_id')
            ->get();

        return view('workouts.index', compact('workouts', 'memberships'));
    }

    public function generateNextWeek(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
        ]);

        $membership = Membership::with(['member', 'trainer'])
            ->findOrFail($request->membership_id);

        if (!$membership->trainer_id) {
            return redirect()
                ->route('workouts.index')
                ->withErrors([
                    'workout' => 'Workout schedule was not generated. This membership has no trainer.',
                ]);
        }

        if (!$membership->schedule_time) {
            return redirect()
                ->route('workouts.index')
                ->withErrors([
                    'workout' => 'Workout schedule was not generated. This membership has no schedule time.',
                ]);
        }

        $generated = app(WorkoutScheduleGenerator::class)
            ->generateNextWeek($membership);

        if (!$generated) {
            return redirect()
                ->route('workouts.index')
                ->withErrors([
                    'workout' => 'Workout schedule was not generated. This member may already have a schedule for that week.',
                ]);
        }

        return redirect()
            ->route('workouts.index')
            ->with('success', 'Next weekly workout schedule generated successfully.');
    }

    public function deleteByMember(Member $member)
    {
        Workout::where('member_id', $member->id)->delete();

        return redirect()
            ->route('workouts.index')
            ->with('success', 'All workouts for this member deleted successfully.');
    }

    public function create()
    {
        $members = Member::all();
        $trainers = Trainer::all();

        return view('workouts.create', compact('members', 'trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'workout_type' => 'required|string',
            'workout_name' => 'required|string',
            'description' => 'nullable|string',
            'workout_date' => 'required|date',
            'workout_time' => 'required|string',
            'status' => 'required|string',
        ]);

        $selectedTime = $this->normalizeWorkoutTime($request->workout_time);

        $slotTaken = Workout::where('trainer_id', $request->trainer_id)
            ->where('day', $request->day)
            ->where('workout_time', $selectedTime)
            ->exists();

        if ($slotTaken) {
            return back()
                ->withInput()
                ->withErrors([
                    'workout_time' => 'This workout time is already booked. Please choose another time.',
                ]);
        }

        Workout::create([
            'member_id' => $request->member_id,
            'trainer_id' => $request->trainer_id,
            'day' => $request->day ?? Carbon::parse($request->workout_date)->format('l'),
            'workout_type' => $request->workout_type,
            'workout_name' => $request->workout_name,
            'description' => $request->description,
            'workout_date' => $request->workout_date,
            'workout_time' => $selectedTime,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('workouts.index')
            ->with('success', 'Workout added successfully.');
    }

    public function show(Workout $workout)
    {
        $workout->load(['member', 'trainer']);

        if (request()->is('api/*')) {
            return response()->json($workout);
        }

        return view('workouts.show', compact('workout'));
    }

    public function edit(Workout $workout)
{
    $workout->load(['member', 'trainer']);

    $timeSlots = [
        '8:00 AM - 9:00 AM',
        '9:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '1:00 PM - 2:00 PM',
        '2:00 PM - 3:00 PM',
        '4:00 PM - 5:00 PM',
    ];

    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    $takenSlotsByDay = [];

    foreach ($days as $day) {
        $takenSlotsByDay[$day] = Workout::where('trainer_id', $workout->trainer_id)
            ->where('day', $day)
            ->where('id', '!=', $workout->id)
            ->whereNotNull('workout_time')
            ->pluck('workout_time')
            ->map(fn ($time) => trim($time))
            ->toArray();
    }

    return view('workouts.edit', compact(
        'workout',
        'timeSlots',
        'takenSlotsByDay',
        'days'
    ));
}

    public function update(Request $request, Workout $workout)
    {
        $request->validate([
            'day' => 'required|string',
            'workout_type' => 'required|string',
            'title' => 'required|string',
            'workout_name' => 'nullable|string',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'workout_date' => 'required|date',
            'time' => 'required|string',
            'workout_time' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $selectedTime = $this->normalizeWorkoutTime($request->time ?? $request->workout_time);

        $slotTaken = Workout::where('trainer_id', $workout->trainer_id)
            ->where('day', $request->day)
            ->where('id', '!=', $workout->id)
            ->where('workout_time', $selectedTime)
            ->exists();

        if ($slotTaken) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'This workout time is already booked for this trainer on ' . $request->day . '. Please choose another time.',
                ]);
        }

        $workout->update([
            'day' => $request->day,
            'workout_type' => $request->workout_type,
            'workout_name' => $request->title ?? $request->workout_name,
            'description' => $request->description ?? $request->details,
            'workout_date' => $request->workout_date,
            'workout_time' => $selectedTime,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('workouts.index')
            ->with('success', 'Workout updated successfully.');
    }
}