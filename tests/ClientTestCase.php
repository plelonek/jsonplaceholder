<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests;

use PHPUnit\Framework\TestCase;
use Plelonek\JsonPlaceholder\Models\Model;

class ClientTestCase extends TestCase
{
    /**
     * @param Model $model
     *
     * @return array
     */
    protected function getModelPredictedAttributes(Model $model): array
    {
        return array_unique(array_merge(
            $model->getFilterable(),
            $model->getFillable()
        ));
    }
}
