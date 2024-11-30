<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserBadge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class AchievementsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_getAchievements_returns_correct_data()
    {
        // Arrange
        $user = User::factory()->create();

        // Mock UserAchievement data (unlocked achievements)
        $unlockedAchievementData1 = [
            'name' => 'Achievement 1',
            'type' => 'lesson', // Example achievement type
        ];
        $unlockedAchievementData2 = [
            'name' => 'Achievement 2',
            'type' => 'comment', // Example achievement type
        ];
        UserAchievement::shouldReceive('get_unlocked_achievements_data')
            ->with($user->id)
            ->andReturn(collect([$unlockedAchievementData1, $unlockedAchievementData2]));
        $this->app->bind(UserAchievement::class, Mockery::mock(UserAchievement::class)); // Mock UserAchievement class

        // Mock UserBadge data (current badge)
        $userBadgeData = [
            'name' => 'Current Badge',
        ];
        UserBadge::shouldReceive('select')
            ->andReturn(collect([$userBadgeData]));
        $this->app->bind(UserBadge::class, Mockery::mock(UserBadge::class)); // Mock UserBadge class

        // Next Badge data (assuming achievement data is already mocked)
        $badge = Badge::factory()->create([
            'required_achievements' => 3, // Example requirement
        ]);

        // Act
        $achievementsData = $user->achievementController->getAchievements($user);

        // Assert
        $this->assertArrayHasKey('unlocked_achievements', $achievementsData);
        $this->assertEquals([$unlockedAchievementData1['name'], $unlockedAchievementData2['name']], $achievementsData['unlocked_achievements']);
        $this->assertCount(2, $achievementsData['unlocked_achievements']); // Assert number of unlocked achievements

        $this->assertEquals($userBadgeData['name'], $achievementsData['current_badge']);

        $this->assertEquals($badge->name, $achievementsData['next_badge']);

        // Remaining achievements for next badge (assuming achievement data is already mocked)
        $unlockedAchievementsCount = count($achievementsData['unlocked_achievements']);
        $requiredAchievements = $badge->required_achievements;
        $this->assertEquals($requiredAchievements - $unlockedAchievementsCount, $achievementsData['remaining_to_unlock_next_badge']);
    }
}
