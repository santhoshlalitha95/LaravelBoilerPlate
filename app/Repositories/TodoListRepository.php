<?php

namespace App\Repositories;

use App\Interfaces\TodoListInterface;
use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class TodoListRepository implements TodoListInterface
{
    public function index(): JsonResponse
    {
        $data = TodoList::all();

        return response()->json($data);
    }

    public function show(int $id): JsonResponse
    {
        $todoList = TodoList::find($id);

        return response()->json($todoList, 200);
    }

    /**
     * Store a new TodoList item.
     *
     * @param  array<string, mixed>  $requestData
     */
    public function store(array $requestData): JsonResponse
    {
        $todoList = TodoList::create($requestData);
        Log::info('This is an informational message new');

        return response()->json($todoList, Response::HTTP_CREATED);
    }

    public function update(Request $request, TodoList $todoList): JsonResponse
    {
        $todoList->update($request->all());

        return response()->json($todoList, Response::HTTP_OK);
    }

    public function destroy(TodoList $todoList): JsonResponse
    {
        $todoList->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
