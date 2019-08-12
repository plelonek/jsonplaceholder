<?php

namespace Plelonek\JsonPlaceholder\Models;

class Comment extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'comments';

    /**
     * @var array
     */
    protected static $filterable = [
        'postId', 'email',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'postId', 'name', 'email', 'body',
    ];
}
