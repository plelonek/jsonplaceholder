<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

class Post extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'posts';

    /**
     * @var array
     */
    protected static $filterable = [
        'id', 'userId', 'title',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'userId', 'title', 'body',
    ];
}
