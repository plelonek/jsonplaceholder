<?php

namespace Plelonek\JsonPlaceholder;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, Countable, Arrayable
{
    /**
     * @var array
     */
    private $items;

    /**
     * Collection constructor.
     *
     * @param  array  $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param  array  $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param $item
     */
    public function push($item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arrayCollection = [];

        foreach ($this->items as $key => $item) {
            if ($item instanceof Arrayable) {
                $arrayCollection[] = $item->toArray();
            } else {
                $arrayCollection[$key] = $this->itemToArray($item);
            }
        }

        return $arrayCollection;
    }

    /**
     * @param $item
     * @return mixed
     */
    private function itemToArray($item)
    {
        if (! is_object($item)) {
            return $item;
        }

        $item = (array) $item;

        foreach ($item as $key => $attribute) {
            if (is_object($attribute)) {
                $item[$key] = $this->itemToArray($attribute);
            }
        }

        return $item;
    }
}
