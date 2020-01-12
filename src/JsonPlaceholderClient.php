<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Http\FilteredUri;
use Plelonek\JsonPlaceholder\Http\HttpClient;
use Plelonek\JsonPlaceholder\Http\SimpleUri;
use Plelonek\JsonPlaceholder\Models\Model;

abstract class JsonPlaceholderClient
{
    private const API_BASE_URI = 'https://jsonplaceholder.typicode.com/';

    /**
     * @var Model
     */
    protected $prototypeModel;

    /**
     * @var HttpClient
     */
    protected $http;

    /**
     * JsonPlaceholderClient constructor.
     */
    public function __construct()
    {
        $this->prototypeModel = $this->getPrototypeModel();

        $this->http = new HttpClient(
            self::API_BASE_URI . $this->prototypeModel->getUri(),
            ['Content-type: application/json; charset=UTF-8']
        );
    }

    /**
     * @param array $filters
     *
     * @return CollectionResult
     */
    public function getAll(array $filters = []): CollectionResult
    {
        $httpResponse = $this->http->get(
            new FilteredUri($filters, $this->prototypeModel->getFilterable())
        );

        return new CollectionResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @param int $resourceId
     *
     * @return ModelResult
     */
    public function get(int $resourceId): ModelResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/${resourceId}")
        );

        return new ModelResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @param array $attributes
     *
     * @return ModelResult
     */
    public function create(array $attributes): ModelResult
    {
        $attributes = $this->prototypeModel->getAllowedFillable($attributes);

        $httpResponse = $this->http->post(
            new SimpleUri('/'),
            json_encode($attributes)
        );

        return new ModelResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @param int $resourceId
     * @param array $attributes
     *
     * @return ModelResult
     */
    public function update(int $resourceId, array $attributes): ModelResult
    {
        $attributes = $this->prototypeModel->getAllowedFillable($attributes);

        $httpResponse = $this->http->put(
            new SimpleUri("/${resourceId}"),
            json_encode($attributes)
        );

        return new ModelResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @param int $resourceId
     *
     * @return ModelResult
     */
    public function delete(int $resourceId): ModelResult
    {
        $httpResponse = $this->http->delete(
            new SimpleUri("/${resourceId}")
        );

        return new ModelResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @param int $resourceId
     * @param string $attribute
     * @param $value
     *
     * @return ModelResult
     */
    public function setAttribute(
        int $resourceId,
        string $attribute,
        $value
    ): ModelResult {
        $postFields = json_encode([
            $attribute => $value,
        ]);

        $httpResponse = $this->http->patch(
            new SimpleUri("/${resourceId}"),
            $postFields
        );

        return new ModelResult($httpResponse, $this->prototypeModel);
    }

    /**
     * @return Model
     */
    abstract protected function getPrototypeModel(): Model;
}
