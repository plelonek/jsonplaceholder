<?php

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
        'id', 'userId',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'userId', 'title', 'body',
    ];
}
