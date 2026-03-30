<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Complete project documentation',
                'due_date' => Carbon::today(),
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Review pull requests',
                'due_date' => Carbon::today(),
                'priority' => 'medium',
                'status' => 'in_progress',
            ],
            [
                'title' => 'Update dependencies',
                'due_date' => Carbon::tomorrow(),
                'priority' => 'low',
                'status' => 'done',
            ],
            [
                'title' => 'Fix critical bug',
                'due_date' => Carbon::today(),
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Write unit tests',
                'due_date' => Carbon::tomorrow(),
                'priority' => 'medium',
                'status' => 'in_progress',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}