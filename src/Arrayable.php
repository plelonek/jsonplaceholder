<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

interface Arrayable
{
    /**
     * @return array
     */
    public function toArray(): array;
}
