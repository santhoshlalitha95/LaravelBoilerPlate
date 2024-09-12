<?php

namespace App\Interfaces;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TaskInterface
{
    public function index(TodoList $todoList): JsonResponse;

    public function store(Request $request, TodoList $todoList): JsonResponse;

    public function update(Request $todoList, Task $task): JsonResponse;

    public function destroy(Task $task): JsonResponse;
}
