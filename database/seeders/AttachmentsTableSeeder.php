<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttachmentsTableSeeder extends Seeder
{
    public function run()
    {
        $tasks = DB::table('tasks')->pluck('id');
        foreach ($tasks as $taskId) {
            foreach (range(1, rand(1, 3)) as $attachmentNum) { 
                DB::table('attachments')->insert([
                    'task_id' => $taskId,
                    'file_path' => "attachement.txt",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}



