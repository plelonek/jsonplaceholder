<?php

namespace Plelonek\JsonPlaceholder;

class CollectionResult extends JsonPlaceholderResult
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @return void
     */
    protected function setResult(): void
    {
        $this->collection = $this->modelFactory->createCollection(
            (array) $this->httpResponse->toJson()
        );
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }
}
