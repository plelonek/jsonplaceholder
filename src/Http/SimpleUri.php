<?php

namespace Plelonek\JsonPlaceholder\Http;

class SimpleUri extends Uri
{
    /**
     * @return string
     */
    public function generate(): string
    {
        return $this->uri;
    }
}
