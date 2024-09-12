<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskRepository implements TaskInterface
{
    public function index(TodoList $todoList): JsonResponse
    {
        $tasks = $todoList->tasks;

        return response()->json($tasks, Response::HTTP_OK);
    }

    public function store(Request $request, TodoList $todoList): JsonResponse
    {
        $task = $todoList->tasks()->create($request->all());

        return response()->json($task, Response::HTTP_CREATED);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $task->update($request->all());

        return response()->json($task, Response::HTTP_NO_CONTENT);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
