<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Services\TaskService;

use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTaskAssignedEmail;

class TaskController extends Controller
{
    
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function create_page()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('create_task_form', compact('users'));
    }

    public function create(Request $request)
    {
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png,docx|max:10240', // 10 MB max size
            'assigned_to' => 'required|exists:users,id',
        ]);
     
        $task = $this->taskService->createTask([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'assigned_to' => $validated['assigned_to'],
            'attachment' => $request->file('attachment') ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');

    }

    public function show($id){
        $task = Task::with(['attachments', 'comments'])->findOrFail($id);

        return view('task_details', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Ensure only the assignee can update the status
        if (auth()->id() !== $task->assigned_to) {
            abort(403, 'Unauthorized action.');
        }
    
        // Validate the new status
        $request->validate([
            'status' => 'required|in:opened,in_progress,completed,closed',
        ]);
    
        // Update the status
        $task->update(['status' => $request->status]);
    
        return redirect()->back()->with('success', 'Task status updated successfully.');
    }
}
