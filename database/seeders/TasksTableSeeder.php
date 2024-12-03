<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TasksTableSeeder extends Seeder
{
    public function run()
{
    $statusOptions = ['opened', 'in_progress', 'completed' , 'closed'];
    $priorityOptions = ['low', 'medium', 'high']; // Add priorities

    $realTasks = [
        ['title' => 'Design Landing Page', 'description' => 'Create a responsive landing page for the marketing campaign.'],
        ['title' => 'Fix Backend API', 'description' => 'Resolve bugs and optimize the user authentication API.'],
        ['title' => 'Prepare Sales Report', 'description' => 'Compile the quarterly sales data into a PowerPoint presentation.'],
        ['title' => 'Update Documentation', 'description' => 'Revise the user guide for the new software version.'],
        ['title' => 'Conduct Code Review', 'description' => 'Review pull requests for the upcoming release cycle.'],
    ];

    foreach (range(1, 3) as $userId) { // Loop for 3 users
        foreach (range(1, 100) as $taskNum) { // Loop to create 100 tasks per user
            $randomTask = $realTasks[array_rand($realTasks)]; // Pick a random task

            // Ensure the task is not assigned to the creator
            $assigneeId = rand(1, 3);
            while ($assigneeId === $userId) {
                $assigneeId = rand(1, 3);
            }

            DB::table('tasks')->insert([
                'title' => $randomTask['title'] . ' (Created by User ' . $userId . ')', // Use the real title
                'description' => 'Dear User ' . $assigneeId . ': ' . $randomTask['description'], // Use the real description
                'status' => $statusOptions[array_rand($statusOptions)], // Random status
                'priority' => $priorityOptions[array_rand($priorityOptions)], // Random priority
                'due_date' => Carbon::now()->addDays(rand(1, 30)), // Random due date
                'created_by' => $userId, // Creator ID
                'assigned_to' => $assigneeId, // Assignee ID
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
}
