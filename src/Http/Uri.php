<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Http;

abstract class Uri
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * Uri constructor.
     *
     * @param  string  $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    abstract public function generate(): string;
}
