<?php

namespace Tests;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->withHeaders([
            'Authorization' => 'Bearer '.JWTAuth::fromUser($this->user),
            'Accept' => 'application/json',
        ]);
        $this->withoutExceptionHandling();
    }

    public function createTodoList($arg = [])
    {
        return TodoList::factory()->create($arg);
    }

    public function makeTodoList($arg = [])
    {
        return TodoList::factory()->make($arg);
    }

    public function createTaskTodoList($arg = [])
    {
        return Task::factory()->create($arg);
    }

    public function makeTaskTodoList($arg = [])
    {
        return Task::factory()->make($arg);
    }

    public function createUser($arg = [])
    {
        return User::factory()->create($arg);
    }

    public function makeUser($arg)
    {
        return User::factory()->make($arg);
    }
}
