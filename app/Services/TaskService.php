<?php
namespace App\Services;

use App\Models\Task;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendTaskAssignedEmail;

class TaskService
{
    public function createTask(array $data)
    {
        // Create task
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'created_by' => Auth::id(),
            'assigned_to' => $data['assigned_to'],
            'status' => 'opened',
            'priority' => $data['priority'],
        ]);

        // Handle file upload if provided
        if (isset($data['attachment'])) {
            $filePath = $data['attachment']->store('attachments', 'public');
            $fileName = $data['attachment']->getClientOriginalName();

            Attachment::create([
                'task_id' => $task->id,
                'file_path' => $filePath,
                'file_name' => $fileName,
            ]);
        }

        // Dispatch email job
        dispatch(new SendTaskAssignedEmail($task));

        return $task;
    }
}
