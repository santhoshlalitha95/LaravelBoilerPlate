<?php

namespace App\Interfaces;

use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TodoListInterface
{
    public function index(): JsonResponse;

    public function show(int $id): JsonResponse;

    /**
     * Store a new TodoList item.
     *
     * @param  array<string, mixed>  $requestData
     */
    public function store(array $requestData): JsonResponse;

    public function update(Request $request, TodoList $todoList): JsonResponse;

    public function destroy(TodoList $todoList): JsonResponse;
}
