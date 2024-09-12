<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testTaskStatusCanBeChanged(): void
    {
        $task = $this->createTaskTodoList();
        $this->patchJson(route('task.update', $task->id), ['status' => Task::STARTED])
            ->assertNoContent();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => Task::STARTED]);

    }
}
