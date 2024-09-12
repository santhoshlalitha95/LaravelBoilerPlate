<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoListRequest;
use App\Models\TodoList;
use App\Repositories\TodoListRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    protected TodoListRepository $todoListRepository;

    public function __construct(TodoListRepository $todoListRepository)
    {
        $this->todoListRepository = $todoListRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/todo-list",
     *     summary="Get all todo lists",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\Items(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="My Todo List"),
     *             @OA\Property(property="description", type="string", example="Description of the todo list")
     *         )
     *     ),
     *
     *     @OA\Tag(name="Todo List")
     * )
     */
    public function index(): JsonResponse
    {
        return $this->todoListRepository->index();
    }

    /**
     * @OA\Get(
     *     path="/api/todo-list/{id}",
     *     summary="Get a single todo list",
     *
     *     @OA\Parameter(
     *         name="id",
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
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="My Todo List"),
     *             @OA\Property(property="description", type="string", example="Description of the todo list")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Todo list not found"
     *     ),
     *
     *     @OA\Tag(name="Todo List")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return $this->todoListRepository->show($id);
    }

    /**
     * @OA\Post(
     *     path="/api/todo-list",
     *     summary="Store a new todo list",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="title", type="string", example="My New Todo List"),
     *             @OA\Property(property="description", type="string", example="Description of the new todo list")
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
     *             @OA\Property(property="title", type="string", example="My New Todo List"),
     *             @OA\Property(property="description", type="string", example="Description of the new todo list")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="Todo List")
     * )
     */
    public function store(StoreTodoListRequest $request): JsonResponse
    {
        $requestData = $request->all();
        $requestData['user_id'] = Auth::guard('api')->id();

        return $this->todoListRepository->store($requestData);
    }

    /**
     * @OA\Put(
     *     path="/api/todo-list/{id}",
     *     summary="Update an existing todo list",
     *
     *     @OA\Parameter(
     *         name="id",
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
     *             @OA\Property(property="title", type="string", example="Updated Todo List Title"),
     *             @OA\Property(property="description", type="string", example="Updated description of the todo list")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully updated",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Updated Todo List Title"),
     *             @OA\Property(property="description", type="string", example="Updated description of the todo list")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Todo list not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="Todo List")
     * )
     */
    public function update(StoreTodoListRequest $request, TodoList $todoList): JsonResponse
    {
        return $this->todoListRepository->update($request, $todoList);
    }

    /**
     * @OA\Delete(
     *     path="/api/todo-list/{id}",
     *     summary="Delete a todo list",
     *
     *     @OA\Parameter(
     *         name="id",
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
     *         description="Todo list not found"
     *     ),
     *
     *     @OA\Tag(name="Todo List")
     * )
     */
    public function destroy(TodoList $todoList): JsonResponse
    {
        return $this->todoListRepository->destroy($todoList);
    }
}
