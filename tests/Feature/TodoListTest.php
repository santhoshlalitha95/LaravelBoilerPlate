<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = $this->createTodoList();
        TodoList::factory(9)->create();
    }

    public function testFetchAllTodoList(): void
    {
        //action / perform
        $response = $this->getJson(route('todo-list.index'));
        //assertion / predict
        $this->assertEquals(10, count($response->json()));
    }

    public function testFetchSingleTodoList(): void
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id))
            ->assertOk()//200
            ->json();
        $this->assertEquals($this->list->title, $response['title']);
    }

    public function testStoreTodoList(): void
    {
        $list = $this->makeTodoList();
        $input = ['title' => $list->title, 'description' => $list->description];
        $response = $this->postJson(route('todo-list.store'), $input)
            ->assertCreated()//201
            ->json();

        $this->assertDatabaseHas('todo_list', $input);
        $this->assertEquals($input['title'], $response['title']);
        $this->assertEquals($input['description'], $response['description']);
    }

    public function testWhileStoringTodoListTitleFieldRequired(): void
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()//422;
            ->assertJsonValidationErrors(['title', 'description']);

        // $this->assertEquals(2, count($response['errors']));
    }

    public function testDeleteTodoList(): void
    {
        $list = $this->createTodoList();
        $respone = $this->deleteJson(route('todo-list.destroy', $list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_list', ['title' => $list->name, 'description' => $list->description]);
    }

    public function testUpdateTodoList(): void
    {
        $list = $this->makeTodoList();
        $input = ['title' => $list->title, 'description' => $list->description];
        $response = $this->putJson(route('todo-list.update', $this->list->id), $input)
            ->assertOk();

        $this->assertDatabaseHas('todo_list', [
            'id' => $this->list->id,
            'title' => $input['title'],
            'description' => $input['description'],
        ]);
        // Highly skilled PHP Developer with 7+ years of experience, specializing in the Laravel framework and team leadership. Committed to delivering robust and efficient web applications, effectively guiding development teams, and excelling under tight deadlines with agile methodologies
    }

    public function testWhileUpdatingTodoListTitleFieldRequired(): void
    {
        $this->withExceptionHandling();
        $response = $this->putJson(route('todo-list.update', $this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'description']);
    }
}
