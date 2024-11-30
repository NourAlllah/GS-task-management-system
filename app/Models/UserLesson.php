<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    use HasFactory;
    protected $table = 'user_lessons';
    protected $fillable = ['user_id', 'lesson_id','watched_at'];

    public static function isUserWatchedLesson($userId, $lessonId)
    {
        return self::where('lesson_id', $lessonId)
            ->where('user_id', $userId)
            ->exists();
    }
}
