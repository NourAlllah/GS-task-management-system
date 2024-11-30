<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    use HasFactory;
    protected $table = 'user_achievements';
    protected $fillable = ['user_id', 'achievement_id'];

    public static function get_unlocked_achievements_data($user_id){

        return  UserAchievement::select('achievements.name', 'achievements.id' , 'achievements.type')
                    ->join('achievements', 'user_achievements.achievement_id', '=', 'achievements.id')
                    ->where('user_achievements.user_id', $user_id)
                    ->get();
                    
    }
}
