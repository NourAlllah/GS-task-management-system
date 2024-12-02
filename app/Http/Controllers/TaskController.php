<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
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
            // Validate that the due_date is a date and is not before today's date
            'due_date' => 'required|date|after_or_equal:' . now()->toDateString(),
            'attachment' => 'nullable|file|mimes:pdf,jpg,png,docx|max:10240', // 10 MB max size
            'assigned_to' => 'required|exists:users,id',
        ]);
    
        // Handle the attachment if it exists
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // store in 'storage/app/public/attachments'
        }

        // Create the task
        $task =  Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'created_by' => auth()->id(),
            'assigned_to' => $validated['assigned_to'],
            'status' => 'open',
            'attachment' => $attachmentPath, // Save the attachment path if it's uploaded
        ]);

         
        return response()->json($task);
        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }
}
