<?php

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Http\HttpResponse;
use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\ModelFactory;

abstract class JsonPlaceholderResult
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    /**
     * @var HttpResponse
     */
    protected $httpResponse;

    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @param HttpResponse $httpResponse
     * @param Model $prototypeModel
     */
    public function __construct(
        HttpResponse $httpResponse,
        Model $prototypeModel
    ) {
        $this->httpResponse = $httpResponse;
        $this->modelFactory = new ModelFactory($prototypeModel);

        if ($this->httpResponse->isError()) {
            $this->setError();
        } else {
            $this->status = self::STATUS_SUCCESS;

            $this->setResult();
        }
    }

    /**
     * @return void
     */
    abstract protected function setResult(): void;

    /**
     * @return void
     */
    protected function setError(): void
    {
        $this->status = self::STATUS_ERROR;

        $this->errorMessage = $this->httpResponse->getErrorMessage();
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->status === self::STATUS_ERROR;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }
}
