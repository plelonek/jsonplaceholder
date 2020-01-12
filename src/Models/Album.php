<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

class Album extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'albums';

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
        'userId', 'title',
    ];
}
