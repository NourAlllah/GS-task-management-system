<?php
namespace App\Jobs;

use App\Mail\AchievementUnlocked;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAchievementUnlockedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $achievement;

    public function __construct($user, $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new AchievementUnlocked($this->user, $this->achievement));
    }
}

