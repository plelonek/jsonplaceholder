<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

class Todo extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'todos';

    /**
     * @var array
     */
    protected static $filterable = [
        'id', 'userId', 'title', 'completed',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'userId', 'title', 'completed',
    ];
}
