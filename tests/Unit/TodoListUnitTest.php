<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TodoListUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function testATodoListHasManyTasks(): void
    {
        $list = $this->createTodoList();
        $task = $this->createTaskTodoList(['todo_list_id' => $list->id]);

        $this->assertInstanceOf(Collection::class, $list->tasks);
        $this->assertInstanceOf(Task::class, $list->tasks->first());
    }

    public function testIfTodoListIsDeletedThenAllItsTasksWillBeDelete(): void
    {
        $list = $this->createTodoList();
        $task1 = $this->createTaskTodoList(['todo_list_id' => $list->id]);
        $task2 = $this->createTaskTodoList(['todo_list_id' => $list->id]);
        $task3 = $this->createTaskTodoList();

        $list->delete();

        $this->assertDatabaseMissing('todo_list', ['id' => $list->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task1->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task2->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task3->id]);
    }
}
