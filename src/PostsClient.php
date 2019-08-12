<?php

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Http\SimpleUri;
use Plelonek\JsonPlaceholder\Models\Comment;
use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Post;

class PostsClient extends JsonPlaceholderClient
{
    /**
     * @return Model
     */
    protected function getPrototypeModel(): Model
    {
        return new Post();
    }

    /**
     * @param int $postId
     * @return CollectionResult
     */
    public function getComments(int $postId): CollectionResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/$postId/comments")
        );

        return new CollectionResult($httpResponse, new Comment());
    }

    /**
     * @param int $postId
     * @param int $userId
     * @return ModelResult
     */
    public function setUserId(int $postId, int $userId): ModelResult
    {
        return $this->setAttribute($postId, 'userId', $userId);
    }

    /**
     * @param int $postId
     * @param string $title
     * @return ModelResult
     */
    public function setTitle(int $postId, string $title): ModelResult
    {
        return $this->setAttribute($postId, 'title', $title);
    }

    /**
     * @param int $postId
     * @param string $body
     * @return ModelResult
     */
    public function setBody(int $postId, string $body): ModelResult
    {
        return $this->setAttribute($postId, 'body', $body);
    }
}
