<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        /* $user = Auth::user();
        $courses = Course::all(); 

        $courses->each(function ($course) use ($userCourse, $user) {
            $course->enrolled = $userCourse::isUserEnrolledInCourse($user->id, $course->id);
        });
           
        return view('dashboard', compact('courses')); */

    }

}


