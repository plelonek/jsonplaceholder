<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Http\SimpleUri;
use Plelonek\JsonPlaceholder\Models\Album;
use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Photo;
use Plelonek\JsonPlaceholder\Tests\Feature\AlbumsClientTest;

/**
 * @see AlbumsClientTest
 */
class AlbumsClient extends JsonPlaceholderClient
{
    /**
     * @param int $albumId
     *
     * @return CollectionResult
     */
    public function getPhotos(int $albumId): CollectionResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/${albumId}/photos")
        );

        return new CollectionResult($httpResponse, new Photo());
    }

    /**
     * @param int $albumId
     * @param int $userId
     *
     * @return ModelResult
     */
    public function setUserId(int $albumId, int $userId): ModelResult
    {
        return $this->setAttribute($albumId, 'userId', $userId);
    }

    /**
     * @param int $albumId
     * @param string $title
     *
     * @return ModelResult
     */
    public function setTitle(int $albumId, string $title): ModelResult
    {
        return $this->setAttribute($albumId, 'title', $title);
    }

    /**
     * @return Model
     */
    protected function getPrototypeModel(): Model
    {
        return new Album();
    }
}
