<?php

namespace App\Models;

use HTMLPurifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TodoList
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $tasks
 */
class TodoList extends Model
{
    use HasFactory;

    protected $table = 'todo_list';

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    protected HTMLPurifier $htmlPurifier;

    /**
     * Constructor with type hinting for attributes parameter.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->htmlPurifier = app(HTMLPurifier::class);
    }

    /**
     * Sanitize multiple attributes.
     *
     * @param  array<string>  $attributes
     */
    public function sanitizeAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->attributes[$attribute] = $this->htmlPurifier->purify($this->attributes[$attribute]);
            }
        }
    }

    /**
     * Override the save method to sanitize attributes before saving.
     *
     * @param  array<string, mixed>  $options
     */
    public function save(array $options = []): bool
    {
        // Specify the columns you want to sanitize
        $this->sanitizeAttributes(['title', 'description']);

        return parent::save($options);
    }

    /**
     * @return HasMany<Task>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return BelongsTo<User, TodoList>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
