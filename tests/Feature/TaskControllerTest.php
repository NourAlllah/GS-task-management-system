<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use App\Services\TaskService;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_displays_the_create_task_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('tasks.create.page'));

        $response->assertStatus(200);
        $response->assertViewIs('create_task_form');
        $response->assertViewHas('users', function ($users) use ($user) {
            return !$users->contains($user); 
        });
    }

    public function test_creates_a_task_and_redirects_to_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'due_date' => now()->addDay()->toDateString(), // 1 day ahead
            'priority' => 'medium',
            'assigned_to' => $user->id,
            'attachment' => UploadedFile::fake()->image('task_attachment.jpg') // Fake file
        ];

        // Mock that the task creation method is called
        $this->mock(TaskService::class, function ($mock) use ($taskData) {
            $mock->shouldReceive('createTask')
                ->once()
                ->with([
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'due_date' => $taskData['due_date'],
                    'priority' => $taskData['priority'],
                    'assigned_to' => $taskData['assigned_to'],
                    'attachment' => $taskData['attachment'], 
                ]);
        });

        $response = $this->post(route('tasks.create'), $taskData);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', 'Task created successfully!');
    }

    public function test_validates_task_creation_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data with missing required fields
        $taskData = [
            'title' => '', // Invalid title
            'description' => 'Test Task Description',
            'due_date' => now()->addDay()->toDateString(),
            'priority' => 'medium',
            'assigned_to' => $user->id,
            'attachment' => null
        ];

        $response = $this->post(route('tasks.create'), $taskData);

        // Assert that the validation fails and we are redirected back to the form
        $response->assertSessionHasErrors('title');
    }
}
