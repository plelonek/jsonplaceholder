<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Models;

use Plelonek\JsonPlaceholder\Collection;

class ModelFactory
{
    /**
     * @var Model
     */
    private $prototypeModel;

    /**
     * @param Model $prototypeModel
     */
    public function __construct(Model $prototypeModel)
    {
        $this->prototypeModel = $prototypeModel;
    }

    /**
     * @param  array  $attributes
     *
     * @return Model|null
     */
    public function createModel(array $attributes): ?Model
    {
        if (! count($attributes)) {
            return null;
        }

        $model = clone $this->prototypeModel;
        $model->setAttributes($attributes);

        return $model;
    }

    /**
     * @param  array  $items
     *
     * @return Collection
     */
    public function createCollection(array $items): Collection
    {
        $collection = new Collection();

        foreach ($items as $item) {
            $collection->push(
                $this->createModel((array) $item)
            );
        }

        return $collection;
    }
}
