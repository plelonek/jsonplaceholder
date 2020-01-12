<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

class CollectionResult extends JsonPlaceholderResult
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @return void
     */
    protected function setResult(): void
    {
        $this->collection = $this->modelFactory->createCollection(
            (array) $this->httpResponse->toJson()
        );
    }
}
