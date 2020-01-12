<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Http;

class FilteredUri extends Uri
{
    /**
     * @var array
     */
    private $filters;

    /**
     * @var array
     */
    private $filterable;

    /**
     * FilteredUri constructor.
     *
     * @param array $filters
     * @param array $filterable
     */
    public function __construct(array $filters, array $filterable)
    {
        $this->filters = $filters;

        $this->filterable = $filterable;

        parent::__construct('/');
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        if (! count($this->filters)) {
            return '/';
        }

        $parameters = [];

        foreach ($this->filters as $attribute => $value) {
            if (in_array($attribute, $this->filterable, true)) {
                $parameters[$attribute] = $value;
            }
        }

        return '?'.http_build_query($parameters);
    }
}
