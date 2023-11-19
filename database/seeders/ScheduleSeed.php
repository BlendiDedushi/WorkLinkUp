<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeed extends Seeder
{
    public function run(): void
    {
        $schedules = [
            'Full-time (9am - 5pm)',
            'Part-time (Flexible Hours)',
            'Contract',
            'Temporary',
            'Internship',
            'Remote',
            'Flexible Hours',
            'Shift Work',
            'Seasonal',
            'Project-Based',
            'On-call',
            'Remote-First',
            'Evening Shift (5pm - 12am)',
            'Weekend Work'
        ];

        foreach ($schedules as $schedule) {
            Schedule::create(['name' => $schedule]);
        }
    }
}
