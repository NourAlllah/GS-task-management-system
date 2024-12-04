<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Start queries for myTasks and assignedTasks
        $myTasksQuery = Task::where('created_by', $user->id);
        $assignedTasksQuery = Task::where('assigned_to', $user->id);

        // Apply filters only if they are present
        if ($request->has('search') && $request->filled('search')) {
            $searchTerm = $request->search;
            $myTasksQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });

            $assignedTasksQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->filled('status')) {
            $myTasksQuery->where('status', $request->status);
            $assignedTasksQuery->where('status', $request->status);
        }

        if ($request->has('priority') && $request->filled('priority')) {
            $myTasksQuery->where('priority', $request->priority);
            $assignedTasksQuery->where('priority', $request->priority);
        }

        if ($request->has('assigned_to') && $request->filled('assigned_to')) {
            $assignedTasksQuery->where('assigned_to', $request->assigned_to);
        }

        // Finalize queries
        $myTasks = $myTasksQuery->get();
        $assignedTasks = $assignedTasksQuery->get();

        $users = User::where('id', '!=', auth()->id())->get();

        return view('dashboard', [
            'myTasks' => $myTasks,
            'assignedTasks' => $assignedTasks,
            'users' => $users,
        ]);
    }

}


