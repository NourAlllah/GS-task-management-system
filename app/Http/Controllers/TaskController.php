<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get all users for the assignee dropdown
        $users = User::all();

        // Start the query
        $query = Task::query();

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Apply assignee filter
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Get tasks for the logged-in user
        $assignedTasks = $query->where('assigned_to', Auth::id())->get();
        $myTasks = Task::where('created_by', Auth::id())->get();

        return view('tasks.index', compact('assignedTasks', 'myTasks', 'users'));
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
            'status' => 'opened',
            'attachment' => $attachmentPath, // Save the attachment path if it's uploaded
        ]);

         
        return response()->json($task);
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
