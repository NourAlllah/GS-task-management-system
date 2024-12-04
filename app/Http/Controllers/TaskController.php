<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTaskAssignedEmail;

class TaskController extends Controller
{
    
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
     
        
        // Create the task
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'created_by' => auth()->id(),
            'assigned_to' => $validated['assigned_to'],
            'status' => 'opened',
            'priority' => $validated['priority']
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
           
            $attachmentPath = $request->file('attachment')->store('attachments', 'public'); 

            $attachment = new Attachment([
                'task_id' => $task->id,
                'file_path' => $attachmentPath,
                'file_name' => $fileName
            ]);
            $attachment->save();
        }

        dispatch(new SendTaskAssignedEmail($task));

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function show($id){
        $task = Task::with(['attachments', 'comments'])->findOrFail($id);

        /* return $task; */
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
