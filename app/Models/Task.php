<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 *
 * @property int $id
 * @property string $task_name
 * @property int $todo_list_id
 * @property-read TodoList $todoList
 */
class Task extends Model
{
    use HasFactory;

    public const NOT_STARTED = 'not_started';

    public const STARTED = 'started';

    public const COMPLETED = 'completed';

    protected $fillable = [
        'task_name',
        'todo_list_id',
        'status',
    ];

    /**
     * Get the todo list that owns the task.
     *
     * @return BelongsTo<TodoList, Task>
     */
    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }
}
