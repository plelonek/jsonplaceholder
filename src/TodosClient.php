<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Todo;
use Plelonek\JsonPlaceholder\Tests\Feature\TodosClientTest;

/**
 * @see TodosClientTest
 */
class TodosClient extends JsonPlaceholderClient
{
    /**
     * @param int $todoId
     * @param int $userId
     *
     * @return ModelResult
     */
    public function setUserId(int $todoId, int $userId): ModelResult
    {
        return $this->setAttribute($todoId, 'userId', $userId);
    }

    /**
     * @param int $todoId
     * @param string $title
     *
     * @return ModelResult
     */
    public function setTitle(int $todoId, string $title): ModelResult
    {
        return $this->setAttribute($todoId, 'title', $title);
    }

    /**
     * @param int $todoId
     *
     * @return ModelResult
     */
    public function setAsCompleted(int $todoId): ModelResult
    {
        return $this->setAttribute($todoId, 'completed', true);
    }

    /**
     * @param int $todoId
     *
     * @return ModelResult
     */
    public function setAsUncompleted(int $todoId): ModelResult
    {
        return $this->setAttribute($todoId, 'completed', false);
    }

    /**
     * @return Model
     */
    protected function getPrototypeModel(): Model
    {
        return new Todo();
    }
}
