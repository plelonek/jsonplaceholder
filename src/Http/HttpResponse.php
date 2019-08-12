<?php

namespace Plelonek\JsonPlaceholder\Http;

class HttpResponse
{
    /**
     * @var string
     */
    protected $rawBody;

    /**
     * @var
     */
    private $errorMessage;

    /**
     * Response constructor.
     * @param string|null $rawBody
     */
    public function __construct(string $rawBody = null)
    {
        $this->rawBody = $rawBody;
    }

    /**
     * @return mixed
     */
    public function toJson()
    {
        return json_decode($this->rawBody, false);
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return (bool) $this->errorMessage;
    }
}
