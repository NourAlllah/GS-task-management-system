<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test; 
use Tests\TestCase;

class UserAchievementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_get_unlocked_achievements_data_returns_unlocked_achievements()
    {
        // Arrange
        $user = User::factory()->create(); // Create a user
        $achievement1 = Achievement::factory()->create(); // Create two achievements
        $achievement2 = Achievement::factory()->create();

        // Create user achievements (unlocked achievements)
        UserAchievement::factory()->create([
            'user_id' => $user->id,
            'achievement_id' => $achievement1->id,
        ]);
        UserAchievement::factory()->create([
            'user_id' => $user->id,
            'achievement_id' => $achievement2->id,
        ]);

        // Act
        $unlockedAchievements = UserAchievement::get_unlocked_achievements_data($user->id);

        // Assert
        $this->assertCount(2, $unlockedAchievements); // Assert two unlocked achievements
        $unlockedAchievementIds = $unlockedAchievements->pluck('id')->toArray();
        $this->assertContains($achievement1->id, $unlockedAchievementIds);
        $this->assertContains($achievement2->id, $unlockedAchievementIds);

    }
}
