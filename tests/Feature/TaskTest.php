<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_redirects_to_tasks(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('tasks.index'));
    }

    public function test_can_list_tasks(): void
    {
        Task::factory()->count(3)->create();
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
    }

    public function test_can_create_task(): void
    {
        $response = $this->post(route('tasks.store'), [
            'title' => 'New Task',
            'priority' => 'medium',
        ]);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create();
        $response = $this->put(route('tasks.update', $task), [
            'title' => 'Updated Task',
            'priority' => 'high',
            'is_completed' => true
        ]);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Task', 'is_completed' => true]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
