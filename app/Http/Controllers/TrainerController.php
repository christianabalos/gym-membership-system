<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Workout;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainerController extends Controller
{
    public function index()
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $timeSlots = [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM',
        ];

        $trainers = Trainer::with([
            'memberships' => function ($query) {
                $query->with('member')
                    ->whereIn('status', ['active', 'approved']);
            },
            'workouts' => function ($query) {
                $query->with(['member', 'membership'])
                    ->whereHas('membership', function ($membershipQuery) {
                        $membershipQuery->whereIn('status', ['active', 'approved']);
                    });
            },
        ])->orderBy('name')->get();

        foreach ($trainers as $trainer) {
            $scheduleGrid = [];

            foreach ($timeSlots as $time) {
                foreach ($days as $day) {
                    $scheduleGrid[$time][$day] = null;
                }
            }

            foreach ($trainer->workouts as $workout) {
                $workoutTime = $this->normalizeWorkoutTime(
                    $workout->schedule_time
                    ?? $workout->workout_time
                    ?? $workout->time
                    ?? ''
                );

                if (!in_array($workoutTime, $timeSlots)) {
                    continue;
                }

                $workoutDay = $workout->day;

                if (!$workoutDay && $workout->workout_date) {
                    $workoutDay = Carbon::parse($workout->workout_date)->format('l');
                }

                if (!in_array($workoutDay, $days)) {
                    continue;
                }

                $memberName = $workout->member->full_name
                    ?? $workout->member->name
                    ?? 'Booked';

                $scheduleGrid[$workoutTime][$workoutDay] = [
                    'member' => $memberName,
                    'title' => $workout->title
                        ?? $workout->workout_title
                        ?? $workout->workout_name
                        ?? 'Workout',
                    'status' => strtolower($workout->status ?? 'scheduled'),
                ];
            }

            $trainer->setAttribute('timeSlots', $timeSlots);
            $trainer->setAttribute('scheduleGrid', $scheduleGrid);
        }

        $weeklyWorkouts = Workout::with(['member', 'trainer', 'membership'])
            ->whereHas('membership', function ($query) {
                $query->whereIn('status', ['active', 'approved']);
            })
            ->orderBy('workout_date')
            ->get();

        $calendarMemberships = Membership::with(['member', 'trainer'])
            ->whereIn('status', ['active', 'approved'])
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->orderBy('start_date')
            ->get();

        return view('trainers.index', compact(
            'trainers',
            'weeklyWorkouts',
            'calendarMemberships',
            'days'
        ));
    }

    private function normalizeWorkoutTime($time)
    {
        $time = trim($time ?? '');

        $map = [
            '8:00 AM' => '8:00 AM - 9:00 AM',
            '08:00 AM' => '8:00 AM - 9:00 AM',
            '8 AM' => '8:00 AM - 9:00 AM',
            '08:00' => '8:00 AM - 9:00 AM',

            '9:00 AM' => '9:00 AM - 10:00 AM',
            '09:00 AM' => '9:00 AM - 10:00 AM',
            '9 AM' => '9:00 AM - 10:00 AM',
            '09:00' => '9:00 AM - 10:00 AM',

            '10:00 AM' => '10:00 AM - 11:00 AM',
            '10 AM' => '10:00 AM - 11:00 AM',
            '10:00' => '10:00 AM - 11:00 AM',

            '1:00 PM' => '1:00 PM - 2:00 PM',
            '01:00 PM' => '1:00 PM - 2:00 PM',
            '1 PM' => '1:00 PM - 2:00 PM',
            '13:00' => '1:00 PM - 2:00 PM',

            '2:00 PM' => '2:00 PM - 3:00 PM',
            '02:00 PM' => '2:00 PM - 3:00 PM',
            '2 PM' => '2:00 PM - 3:00 PM',
            '14:00' => '2:00 PM - 3:00 PM',

            '4:00 PM' => '4:00 PM - 5:00 PM',
            '04:00 PM' => '4:00 PM - 5:00 PM',
            '4 PM' => '4:00 PM - 5:00 PM',
            '16:00' => '4:00 PM - 5:00 PM',
        ];

        return $map[$time] ?? $time;
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email',
            'phone' => 'nullable|string|max:50',
            'specialization' => 'required|string|max:255',
        ]);

        Trainer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
        ]);

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer added successfully.');
    }

    public function show(Trainer $trainer)
    {
        $trainer->load([
            'memberships' => function ($query) {
                $query->with('member')
                    ->whereIn('status', ['active', 'approved']);
            },
            'workouts' => function ($query) {
                $query->with(['member', 'membership'])
                    ->whereHas('membership', function ($membershipQuery) {
                        $membershipQuery->whereIn('status', ['active', 'approved']);
                    });
            },
        ]);

        return view('trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'nullable|string|max:50',
            'specialization' => 'required|string|max:255',
        ]);

        $trainer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
        ]);

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer deleted successfully.');
    }
}