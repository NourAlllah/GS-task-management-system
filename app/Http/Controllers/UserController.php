<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
    
        $user = auth()->user();

        $myTasks = Task::where('created_by', $user->id)->get();
        $assignedTasks = Task::where('assigned_to', $user->id)->get();

/*         return [$myTasks , $assignedTasks];
 */        return view('dashboard', [
            'myTasks' => $myTasks,         
            'assignedTasks' => $assignedTasks, 
        ]);


    }

}


