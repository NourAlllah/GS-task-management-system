<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\UserLesson;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AchievementController; 
use App\Http\Controllers\BadgeController; 

use function PHPSTORM_META\type;

class LessonController extends Controller
{
    public function show(Lesson $lesson , course $course ,)
    {
        $comments = $lesson->comments()->with('user')->get();

        return view('lesson_details', compact('lesson','comments'));
    }

    public function watch(Request $request, Course $course, Lesson $lesson)
    {

        $user = Auth::user();
    
        $alreadyWatched = UserLesson::where('user_id', $user->id)
                                    ->where('lesson_id', $lesson->id)
                                    ->exists();
        

        if (!$alreadyWatched) {

            UserLesson::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'watched_at' => now(), 
            ]);

            //check achievemnts of user and update
                $type = 'lesson'; 

                $userAchivements = AchievementController::checkUpdateAcheivement($type);
            //

            // check badges and update 
                 $userBadges = BadgeController::checkUpdateBadges($userAchivements);
                
            return redirect()->route('lessons.show', [ 'lesson' => $lesson->id])->with('status', true)->with('message', 'Congratulations! you just watched another lesson..');
        }else{
            return redirect()->route('lessons.show', [ 'lesson' => $lesson->id])->with('status', true)->with('message', 'Revesion is always useful, Keep it up!');
        }


    }
}
