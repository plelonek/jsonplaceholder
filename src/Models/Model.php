<?php

namespace Plelonek\JsonPlaceholder\Models;

use Plelonek\JsonPlaceholder\Arrayable;
use Plelonek\JsonPlaceholder\Collection;

abstract class Model implements Arrayable
{
    /**
     * @var string
     */
    protected static $uri;

    /**
     * @var array
     */
    protected static $filterable = [];

    /**
     * @var array
     */
    protected static $fillable = [];

    /**
     * @var Collection
     */
    protected $attributes;

    /**
     * Model constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = new Collection($attributes);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return static::$uri;
    }

    /**
     * @return array
     */
    public function getFilterable(): array
    {
        return static::$filterable;
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function getAllowedFillable(array $attributes): array
    {
        return array_filter($attributes, static function ($key) {
            return in_array($key, static::$fillable, true);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    /**
     * @param  array  $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = new Collection($attributes);
    }

    /**1
     * @param  string  $key
     * @return mixed|null
     */
    public function getAttribute(string $key)
    {
        if (array_key_exists($key, $this->attributes->getItems())) {
            return $this->attributes->getItems()[$key];
        }

        return null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes->toArray();
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->attributes = new Collection();
    }
}
