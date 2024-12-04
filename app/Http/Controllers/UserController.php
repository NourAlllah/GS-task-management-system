<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $myTasksQuery = Task::where('created_by', $user->id);
        $assignedTasksQuery = Task::where('assigned_to', $user->id);

        $this->applyFilters($myTasksQuery, $request);
        $this->applyFilters($assignedTasksQuery, $request, true);

        $myTasks = $myTasksQuery->get();
        $assignedTasks = $assignedTasksQuery->get();
        $users = User::where('id', '!=', $user->id)->get();

        
        return view('dashboard', [
            'myTasks' => $myTasks,
            'assignedTasks' => $assignedTasks,
            'users' => $users,
        ]);
        return view('dashboard', compact('myTasks', 'assignedTasks', 'users'));
    }

    private function applyFilters($query, Request $request, $isAssignedQuery = false)
    {
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($isAssignedQuery && $request->filled('assigned_to')) {
            $query->where('assigned_to', $request->input('assigned_to'));
        }
    }
}
