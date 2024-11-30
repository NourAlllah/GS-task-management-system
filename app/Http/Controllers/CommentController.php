<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function submit(Request $request , Lesson $lesson){

        $validatedData = $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id, 
            'lesson_id' => $request->lesson, 
            'content' => $request->comment,
        ]);

        //check achievemnts of user and update 
                
            $type = 'comment'; 

            $achievementStatus = AchievementController::checkUpdateAcheivement($type);

        //

        // check badges and update 

            $userBadges = BadgeController::checkUpdateBadges($achievementStatus);
            
        //

        return back()->with('status', true)->with('message', 'Comment submitted successfully!');
    }
}
