<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = [
            [
                'email' => 'james.trainer@gmail.com',
                'user_id' => null,
                'name' => 'James Patrick Cabaluna',
                'phone' => '0953096675',
                'specialization' => 'Strength Training',
            ],
            [
                'email' => 'christian.trainer@gmail.com',
                'user_id' => null,
                'name' => 'Christian James Abalos',
                'phone' => '09123456782',
                'specialization' => 'Cardio Training',
            ],
            [
                'email' => 'claire.trainer@gmail.com',
                'user_id' => null,
                'name' => 'Bhing Marie Claire Untal',
                'phone' => '09123456783',
                'specialization' => 'Weight Loss',
            ],
            [
                'email' => 'mary.trainer@gmail.com',
                'user_id' => null,
                'name' => 'Mary Kristine Calado',
                'phone' => '09123456784',
                'specialization' => 'Flexibility / General Fitness',
            ],
        ];

        $emails = collect($trainers)->pluck('email')->toArray();

        $oldTrainerIds = Trainer::whereNotIn('email', $emails)->pluck('id');

        Membership::whereIn('trainer_id', $oldTrainerIds)->update([
            'trainer_id' => null,
        ]);

        Member::whereIn('trainer_id', $oldTrainerIds)->update([
            'trainer_id' => null,
        ]);

        Trainer::whereNotIn('email', $emails)->delete();

        foreach ($trainers as $trainerData) {
            Trainer::updateOrCreate(
                ['email' => $trainerData['email']],
                $trainerData
            );
        }
    }
}