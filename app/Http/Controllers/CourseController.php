<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\UserCourse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show(Course $course, UserCourse $userCourse)
    {
         $user = Auth::user();

        $course->enrolled = $userCourse::isUserEnrolledInCourse($user->id, $course->id);

        $lessons = $course->lessons; 

        return view('course_details', compact('course', 'lessons'));
    }

    public function enroll(Request $request, Course $course)
    {
        $user = Auth::user();
    
        UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now()
        ]);

        return redirect()->back()
        ->with('status', 'Enrolled!')
        ->with('courseId', $course->id); 
        
       
    }
}
