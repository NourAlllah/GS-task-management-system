<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;
    protected $table = 'user_courses';
    protected $fillable = ['user_id', 'course_id','enrolled_at'];

    public static function isUserEnrolledInCourse($userId, $courseId)
    {
        return self::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->exists();
    }
    
}
