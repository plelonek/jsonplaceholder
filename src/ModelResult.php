<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Models\Model;

class ModelResult extends JsonPlaceholderResult
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @return void
     */
    protected function setResult(): void
    {
        $this->model = $this->modelFactory->createModel(
            (array) $this->httpResponse->toJson()
        );
    }
}
