<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

class User extends Model
{
    /**
     * @var string
     */
    protected static $uri = 'users';

    /**
     * @var array
     */
    protected static $filterable = [
        'id', 'username', 'email', 'phone', 'website',
    ];

    /**
     * @var array
     */
    protected static $fillable = [
        'name', 'username', 'email', 'address', 'phone', 'website', 'company',
    ];
}
