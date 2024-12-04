<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
    
        $user = auth()->user();

        $myTasks = Task::where('created_by', $user->id)->get();
        $assignedTasks = Task::where('assigned_to', $user->id)->get();
        $users = User::where('id', '!=', auth()->id())->get();

/*         return [$myTasks , $assignedTasks];
 */        return view('dashboard', [
            'myTasks' => $myTasks,         
            'assignedTasks' => $assignedTasks, 
            'users' => $users
        ]);


    }

}


