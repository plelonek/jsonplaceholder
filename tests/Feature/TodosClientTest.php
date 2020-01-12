<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests\Feature;

use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Todo;
use Plelonek\JsonPlaceholder\Tests\ClientTestCase;
use Plelonek\JsonPlaceholder\TodosClient;

/**
 * @covers \Plelonek\JsonPlaceholder\TodosClient
 * @covers \Plelonek\JsonPlaceholder\JsonPlaceholderClient
 */
class TodosClientTest extends ClientTestCase
{
    /**
     * @var TodosClient
     */
    private $todosClient;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->todosClient = new TodosClient();
    }

    /**
     * @return void
     */
    public function testGetAllTodos(): void
    {
        $collectionResult = $this->todosClient->getAll();

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 200
        );
    }

    /**
     * @return void
     */
    public function testGetAllFilteredTodos(): void
    {
        $filteredUserId = 1;

        $collectionResult = $this->todosClient->getAll([
            'userId' => $filteredUserId,
            'notFilterableAttribute' => true,
        ]);

        $this->assertTrue($collectionResult->isSuccess());

        foreach ($collectionResult->getCollection() as $todo) {
            /** @var Model $todo */

            $this->assertSame(
                $todo->getAttribute('userId'),
                $filteredUserId
            );
        }
    }

    /**
     * @return void
     */
    public function testGetTodo(): void
    {
        $todoId = 1;
        $modelResult = $this->todosClient->get($todoId);

        $this->assertTrue($modelResult->isSuccess());
        $todo = $modelResult->getModel();

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertSame($todo->getAttribute('id'), $todoId);

        $todoAttributes = $todo->getAttributes()->toArray();
        $predictedAttributes = $this->getModelPredictedAttributes($todo);

        foreach ($predictedAttributes as $attribute) {
            $this->assertArrayHasKey($attribute, $todoAttributes);
        }
    }

    /**
     * @return void
     */
    public function testCreateTodo(): void
    {
        $notFillableAttribute = 'notFillableAttribute';

        $data = [
            'userId' => 1,
            'title' => 'This is a title',
            'completed' => false,
            $notFillableAttribute => 'This is not fillable attribute',
        ];

        $modelResult = $this->todosClient->create($data);
        $todo = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        foreach (['userId', 'title', 'completed'] as $attribute) {
            $this->assertSame(
                $todo->getAttribute($attribute), $data[$attribute]
            );
        }

        $this->assertArrayNotHasKey(
            $notFillableAttribute,
            $todo->getAttributes()->toArray()
        );
    }

    /**
     * @return void
     */
    public function testUpdateTodo(): void
    {
        $todoId = 1;
        $data = [
            'userId' => 2,
            'title' => 'This is a title',
            'completed' => true,
        ];

        $modelResult = $this->todosClient->update($todoId, $data);
        $todo = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        foreach (['userId', 'title', 'completed'] as $attribute) {
            $this->assertSame(
                $todo->getAttribute($attribute), $data[$attribute]
            );
        }

        $this->assertSame($todo->getAttribute('id'), $todoId);
    }

    /**
     * @return void
     */
    public function testDeleteTodo(): void
    {
        $todoId = 1;
        $modelResult = $this->todosClient->delete($todoId);

        $this->assertTrue($modelResult->isSuccess());
        $this->assertNull($modelResult->getModel());
    }

    /**
     * @return void
     */
    public function testSetUserId(): void
    {
        $newUserId = 2;
        $modelResult = $this->todosClient->setUserId(1, $newUserId);

        $this->assertTrue($modelResult->isSuccess());

        $todo = $modelResult->getModel();
        $this->assertSame($todo->getAttribute('userId'), $newUserId);
    }

    /**
     * @return void
     */
    public function testSetTitle(): void
    {
        $newTitle = 'This is a new title';
        $modelResult = $this->todosClient->setTitle(1, $newTitle);

        $this->assertTrue($modelResult->isSuccess());

        $todo = $modelResult->getModel();
        $this->assertSame($todo->getAttribute('title'), $newTitle);
    }

    /**
     * @return void
     */
    public function testSetAsCompleted(): void
    {
        $modelResult = $this->todosClient->setAsCompleted(1);

        $this->assertTrue($modelResult->isSuccess());

        $todo = $modelResult->getModel();
        $this->assertTrue($todo->getAttribute('completed'));
    }

    /**
     * @return void
     */
    public function testSetAsUncompleted(): void
    {
        $modelResult = $this->todosClient->setAsUncompleted(4);

        $this->assertTrue($modelResult->isSuccess());

        $todo = $modelResult->getModel();
        $this->assertFalse($todo->getAttribute('completed'));
    }
}
