<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $achievement;

    public function __construct($user, $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }

    public function build()
    {
        return $this->subject($this->achievement->description)
                    ->view('emails.achievement_unlocked')
                    ->with([
                        'userName' => $this->user->name,
                        'achievementName' => $this->achievement->name,
                    ]);
    }
}


