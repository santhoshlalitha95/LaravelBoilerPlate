<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Interfaces\TaskInterface;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected TaskInterface $taskRepository;

    public function __construct(TaskInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/todo-list/{todo_list_id}/task",
     *     summary="Get tasks of a todo lists ",
     *
     *     @OA\Parameter(
     *         name="todo_list_id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\Items(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="task_name", type="string", example="My Task"),
     *             @OA\Property(property="todo_list_id", type="string", example="todo list id")
     *         )
     *     ),
     *
     *     @OA\Tag(name="Tasks")
     * )
     */
    public function index(TodoList $todoList): JsonResponse
    {
        return $this->taskRepository->index($todoList);
    }

    /**
     * @OA\Post(
     *     path="/api/todo-list/{todo_list_id}/task",
     *     summary="Store a new todo list task",
     *
     *     @OA\Parameter(
     *         name="todo_list_id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="task_name", type="string", example="My New Todo List Task"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="task_name", type="string", example="My New Todo List"),
     *             @OA\Property(property="todo_list_id", type="int", example="1")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="Tasks")
     * )
     */
    public function store(StoreTaskRequest $request, TodoList $todoList): JsonResponse
    {
        return $this->taskRepository->store($request, $todoList);
    }

    /**
     * @OA\Put(
     *     path="/api/task/{task_id}",
     *     summary="Update task",
     *
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="task_name", type="string", example="Updated Task"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="task_name", type="string", example="Updated Task"),
     *             @OA\Property(property="todo_list_id", type="int", example="1")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="Tasks")
     * )
     */
    public function update(StoreTaskRequest $request, Task $task): JsonResponse
    {
        return $this->taskRepository->update($request, $task);
    }

    /**
     * @OA\Delete(
     *     path="/api/task/{task_id}",
     *     summary="Delete a task",
     *
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="Successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     *
     *     @OA\Tag(name="Tasks")
     * )
     */
    public function destroy(Task $task): JsonResponse
    {
        return $this->taskRepository->destroy($task);
    }
}
