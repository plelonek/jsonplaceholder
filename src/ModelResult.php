<?php

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Models\Model;

class ModelResult extends JsonPlaceholderResult
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @return void
     */
    protected function setResult(): void
    {
        $this->model = $this->modelFactory->createModel(
            (array) $this->httpResponse->toJson()
        );
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
