<?php

namespace App\Services;

use App\Models\Workout;
use App\Models\Membership;
use Carbon\Carbon;

class WorkoutScheduleGenerator
{
    public function generateNextWeek(Membership $membership)
    {
        if (!$membership->trainer_id || !$membership->schedule_time) {
            return false;
        }

        $memberId = $membership->member_id;
        $trainerId = $membership->trainer_id;
        $membershipId = $membership->id;

        $startDate = now()->startOfWeek(Carbon::MONDAY)->addWeek();

        $alreadyExists = Workout::where('member_id', $memberId)
            ->whereBetween('workout_date', [
                $startDate->copy()->toDateString(),
                $startDate->copy()->addDays(6)->toDateString(),
            ])
            ->exists();

        if ($alreadyExists) {
            return false;
        }

        $scheduleTime = $membership->schedule_time;

        $workouts = [
            [
                'day' => 'Monday',
                'workout_type' => 'Upper Body',
                'workout_name' => 'Upper Body Toning',
                'description' => 'Light dumbbell press, rows, lateral raises, curls, tricep extensions.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Tuesday',
                'workout_type' => 'Conditioning',
                'workout_name' => 'Calorie Burn Workout',
                'description' => 'Burpees, jumping jacks, treadmill intervals, battle ropes.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Wednesday',
                'workout_type' => 'Recovery',
                'workout_name' => 'Recovery Day',
                'description' => 'Rest, stretching, hydration, and light walking.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Thursday',
                'workout_type' => 'Full Body',
                'workout_name' => 'Weight Loss Circuit',
                'description' => 'Bodyweight squats, push-ups, lunges, jumping jacks, plank holds.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Friday',
                'workout_type' => 'Cardio',
                'workout_name' => 'Fat Burn Cardio',
                'description' => 'Treadmill walk, cycling, jump rope, mountain climbers.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Saturday',
                'workout_type' => 'Core',
                'workout_name' => 'Core Fat Loss Workout',
                'description' => 'Planks, crunches, leg raises, Russian twists, bicycle crunches.',
                'status' => 'scheduled',
            ],
            [
                'day' => 'Sunday',
                'workout_type' => 'Rest Day',
                'workout_name' => 'Sunday Rest',
                'description' => 'Full rest day. Recovery only.',
                'status' => 'rest',
            ],
        ];

        foreach ($workouts as $index => $item) {
            Workout::create([
                'membership_id' => $membershipId,
                'member_id' => $memberId,
                'trainer_id' => $trainerId,
                'day' => $item['day'],
                'workout_type' => $item['workout_type'],
                'workout_name' => $item['workout_name'],
                'description' => $item['description'],
                'workout_date' => $startDate->copy()->addDays($index)->toDateString(),
                'workout_time' => $scheduleTime,
                'status' => $item['status'],
            ]);
        }

        return true;
    }
}