<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests\Feature;

use Plelonek\JsonPlaceholder\Models\Comment;
use Plelonek\JsonPlaceholder\Models\Post;
use Plelonek\JsonPlaceholder\PostsClient;
use Plelonek\JsonPlaceholder\Tests\ClientTestCase;

/**
 * @covers \Plelonek\JsonPlaceholder\PostsClient
 * @covers \Plelonek\JsonPlaceholder\JsonPlaceholderClient
 */
class PostsClientTest extends ClientTestCase
{
    /**
     * @var PostsClient
     */
    private $postsClient;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->postsClient = new PostsClient();
    }

    /**
     * @return void
     */
    public function testGetAllPosts(): void
    {
        $collectionResult = $this->postsClient->getAll();

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 100
        );
    }

    /**
     * @return void
     */
    public function testGetAllFilteredPosts(): void
    {
        $filteredUserId = 1;

        $collectionResult = $this->postsClient->getAll([
            'userId' => $filteredUserId,
            'notFilterableAttribute' => true,
        ]);

        $this->assertTrue($collectionResult->isSuccess());

        foreach ($collectionResult->getCollection() as $post) {
            /** @var Post $post */

            $this->assertSame(
                $post->getAttribute('userId'),
                $filteredUserId
            );
        }
    }

    /**
     * @return void
     */
    public function testGetPost(): void
    {
        $postId = 1;
        $modelResult = $this->postsClient->get($postId);

        $this->assertTrue($modelResult->isSuccess());
        $post = $modelResult->getModel();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertSame($post->getAttribute('id'), $postId);

        $postAttributes = $post->getAttributes()->toArray();
        $predictedAttributes = $this->getModelPredictedAttributes($post);

        foreach ($predictedAttributes as $attribute) {
            $this->assertArrayHasKey($attribute, $postAttributes);
        }
    }

    /**
     * @return void
     */
    public function testCreatePost(): void
    {
        $notFillableAttribute = 'notFillableAttribute';

        $data = [
            'userId' => 1,
            'title' => 'This is a title',
            'body' => 'This is a body',
            $notFillableAttribute => 'This is not fillable attribute',
        ];

        $modelResult = $this->postsClient->create($data);

        $this->assertTrue($modelResult->isSuccess());

        $post = $modelResult->getModel();
        $this->assertSame($post->getAttribute('userId'), $data['userId']);
        $this->assertSame($post->getAttribute('title'), $data['title']);
        $this->assertSame($post->getAttribute('body'), $data['body']);

        $this->assertArrayNotHasKey(
            $notFillableAttribute,
            $post->getAttributes()->toArray()
        );
    }

    /**
     * @return void
     */
    public function testUpdatePost(): void
    {
        $postId = 1;
        $data = [
            'userId' => 2,
            'title' => 'This is a new title',
            'body' => 'This is a new body',
        ];

        $modelResult = $this->postsClient->update($postId, $data);
        $post = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        foreach (['userId', 'title', 'body'] as $attribute) {
            $this->assertSame(
                $post->getAttribute($attribute), $data[$attribute]
            );
        }

        $this->assertSame($post->getAttribute('id'), $postId);
    }

    /**
     * @return void
     */
    public function testDeletePost(): void
    {
        $postId = 1;
        $modelResult = $this->postsClient->delete($postId);

        $this->assertTrue($modelResult->isSuccess());
        $this->assertNull($modelResult->getModel());
    }

    /**
     * @return void
     */
    public function testGetComments(): void
    {
        $collectionResult = $this->postsClient->getComments(1);

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 500
        );

        $firstComment = $collectionResult->getCollection()[0];

        $this->assertInstanceOf(Comment::class, $firstComment);
    }

    /**
     * @return void
     */
    public function testSetUserId(): void
    {
        $newUserId = 2;
        $modelResult = $this->postsClient->setUserId(1, $newUserId);

        $this->assertTrue($modelResult->isSuccess());

        $post = $modelResult->getModel();
        $this->assertSame($post->getAttribute('userId'), $newUserId);
    }

    /**
     * @return void
     */
    public function testSetTitle(): void
    {
        $newTitle = 'This is a new title';
        $modelResult = $this->postsClient->setTitle(1, $newTitle);

        $this->assertTrue($modelResult->isSuccess());

        $post = $modelResult->getModel();
        $this->assertSame($post->getAttribute('title'), $newTitle);
    }

    /**
     * @return void
     */
    public function testSetBody(): void
    {
        $newBody = 'This is a new body';
        $modelResult = $this->postsClient->setBody(1, $newBody);

        $this->assertTrue($modelResult->isSuccess());

        $post = $modelResult->getModel();
        $this->assertSame($post->getAttribute('body'), $newBody);
    }
}
