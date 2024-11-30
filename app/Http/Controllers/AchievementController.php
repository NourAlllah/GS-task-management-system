<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Badge;

use App\Models\UserAchievement;
use App\Models\UserBadge;


use Illuminate\Support\Facades\Auth;
use App\Jobs\SendAchievementUnlockedEmail;

use Illuminate\Http\Request;

class AchievementController extends Controller
{

    public function getAchievements(User $user){

        //unlocked_achievements (string[ ])

            $unlocked_achievements_data = UserAchievement::get_unlocked_achievements_data($user->id);
            
            $unlocked_achievements = []; //required
            
            foreach ($unlocked_achievements_data as $achievement) {
                $unlocked_achievements[] = $achievement['name'];
            }

        //next_available_achievements (string[ ])

            $next_available_achievements = $this->getNextAvailableAchievements($unlocked_achievements_data);

        //  current_badge (string)         
            $userbadges_data = UserBadge::select('badges.name', 'badges.id')
                ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
                ->orderBy('user_badges.created_at', 'desc')
                ->limit(1)
                ->get();

            $current_badge =  $userbadges_data[0]->name; //required
        // next_badge (string)
            $next_badge_id = $userbadges_data[0]->id + 1;
            $badge = Badge::find($next_badge_id);

            $next_badge = $badge->name; //required
        //  remaining_to_unlock_next_badge (int)
            $numberCurrentAchievements = count($unlocked_achievements_data);
            $nextBadgeAchievements = $badge->required_achievements;

            $remaining_to_unlock_next_badge =  $nextBadgeAchievements - $numberCurrentAchievements ; //required 

        return [
            'unlocked_achievements'=> $unlocked_achievements,
            'next_available_achievements' =>  $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaining_to_unlock_next_badge' => $remaining_to_unlock_next_badge
        ];
        
    }

    private function getNextAvailableAchievements($unlocked_achievements_data){

        $groupedByType = [];
        foreach ($unlocked_achievements_data as $achievement) {
            $type = $achievement['type'];
            
            $groupedByType[$type][] = $achievement;
        }

        $highestByType = [];
        foreach ($groupedByType as $type => $achievements) {
            $highestByType[$type] = max(array_values(array_column($achievements, 'id', 'id')));
        }

        $next_available_achievements = []; //required

        foreach ($highestByType as $type => $id) {
            $achievements = Achievement::select('achievements.*')
            ->where('type', $type)
            ->where('id', $id+1)
            ->get();
            if (count($achievements) > 0) {
                $next_available_achievements[] = $achievements->first()->name; 
            }
        }

        return $next_available_achievements;
    }

    public static function checkUpdateAcheivement($type){

        $user = Auth::user();

        $achievements_types = ['lesson' =>'lessons' ,'comment'=>'comments'];

        $model_function = $achievements_types[$type];

        $user_data_actions = $user->$model_function;


        $userAchievements = Achievement::ofType($type)->get();

        foreach ($userAchievements as $userAchievement_data) {

            if ($userAchievement_data->threshold <= count($user_data_actions)) {

                $check_achievemnt_exist = UserAchievement::where('user_id', $user->id)
                            ->where('achievement_id', $userAchievement_data->id)
                            ->exists();

                if (!$check_achievemnt_exist) {

                    $final_user_achievments= UserAchievement::create([
                        'user_id' => $user->id,
                        'achievement_id' => $userAchievement_data->id,
                    ]);

                    // job of email 
                        SendAchievementUnlockedEmail::dispatch($user, $userAchievement_data);
                    //
                }

            }

        }

        $all_user_achievements = UserAchievement::where('user_id', $user->id)->get();

        return count($all_user_achievements);


    }
}
