<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Task;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $user;
    public $assignedUser;
    
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->user = $task->user; 
        $this->assignedUser = $task->assignedUser; 
    }

    public function build()
    {
        $email = $this->subject('You have been assigned a new task!')
                      ->view('emails.task_assigned')
                      ->with([
                          'task' => $this->task,
                          'user' => $this->user,
                          'assignedUser' => $this->assignedUser,
                      ]);

        return $email;
    }
}
