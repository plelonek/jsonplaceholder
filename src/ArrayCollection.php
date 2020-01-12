<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

class ArrayCollection
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * ArrayCollection constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->convertToArray($collection);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Collection $collection
     *
     * @return void
     */
    private function convertToArray(Collection $collection): void
    {
        foreach ($collection->getItems() as $key => $item) {
            if ($item instanceof Arrayable) {
                $this->items[] = $item->toArray();
            } else {
                $this->items[$key] = $this->itemToArray($item);
            }
        }
    }

    /**
     * @param $item
     *
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
