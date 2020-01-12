<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

class Photo extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'photos';

    /**
     * @var array
     */
    protected static $filterable = [
        'id', 'albumId', 'title', 'url', 'thumbnailUrl',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'albumId', 'title', 'url', 'thumbnailUrl',
    ];
}
