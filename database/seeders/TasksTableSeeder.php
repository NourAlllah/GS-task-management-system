<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    
    public function run(): void
    {
        $statusOptions = ['open', 'in_progress', 'completed'];

        foreach (range(1, 3) as $userId) { 
            foreach (range(1, 100) as $taskNum) { 
                DB::table('tasks')->insert([
                    'title' => "Task $taskNum by User $userId",
                    'description' => "Description for Task $taskNum by User $userId",
                    'status' => $statusOptions[array_rand($statusOptions)], 
                    'due_date' => now()->addDays(rand(1, 30)),
                    'created_by' => $userId,
                    'assigned_to' => rand(1, 3), 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
