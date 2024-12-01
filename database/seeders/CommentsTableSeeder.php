<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $tasks = DB::table('tasks')->pluck('id');
        foreach ($tasks as $taskId) {
            foreach (range(1, rand(1, 3)) as $commentNum) { 
                DB::table('comments')->insert([
                    'task_id' => $taskId,
                    'user_id' => rand(1, 3), 
                    'comment' => "This is comment $commentNum for task $taskId",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
