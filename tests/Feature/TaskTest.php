<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    private $list;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = $this->createTodoList();
    }

    public function testFetchAllTasksOfTodoList(): void
    {
        $task1 = $this->createTaskTodoList(['todo_list_id' => $this->list->id]);
        $task2 = $this->createTaskTodoList();
        $response = $this->getJson(route('todo-list.task.index', $this->list->id))
            ->assertOk()
            ->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task1->task_name, $response[0]['task_name']);
        $this->assertEquals($task1->todo_list_id, $this->list->id);
    }

    public function testStoreTaskOfTodoList(): void
    {
        $task = $this->makeTaskTodoList(['todo_list_id' => $this->list->id]);
        $respinse = $this->postJson(route('todo-list.task.store', $this->list->id), ['task_name' => $task->task_name])
            ->assertCreated();
        $this->assertDatabaseHas('tasks', ['task_name' => $task->task_name, 'todo_list_id' => $this->list->id]);
    }

    public function testUpdateTaskOfTodoList(): void
    {
        $task = $this->createTaskTodoList(['todo_list_id' => $this->list->id]);
        $this->putJson(route('task.update', $task->id), ['task_name' => 'new one'])
            ->assertNoContent();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'task_name' => 'new one']);
    }

    public function testDeleteTaskOfTodoList(): void
    {
        $task = $this->createTaskTodoList(['todo_list_id' => $this->list->id]);
        $response = $this->deleteJson(route('task.destroy', $task->id))
            ->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
