<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function testTaskBelongsToTodoList(): void
    {
        $list = $this->createTodoList();
        $task = $this->createTaskTodoList(['todo_list_id' => $list->id]);

        $this->assertInstanceOf(TodoList::class, $task->todoList);
    }
}
