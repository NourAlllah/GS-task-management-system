<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Badge;
use App\Models\UserBadge;


use Illuminate\Http\Request;

class BadgeController extends Controller
{
   
    public static function checkUpdateBadges($userAchivementsCount){

        $user = Auth::user();

        $Badges = Badge::all();

        foreach ($Badges as $Badge ) {
           if ($Badge->required_achievements <=  $userAchivementsCount) {
                $check_badge_exist = UserBadge::where('user_id', $user->id)
                    ->where('badge_id', $Badge->id)
                    ->exists();

                if (!$check_badge_exist) {
                    UserBadge::create([
                        'user_id' => $user->id,
                        'badge_id' => $Badge->id,
                    ]);
                }
            } 
        }

    }
}
