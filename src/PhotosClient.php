<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Photo;
use Plelonek\JsonPlaceholder\Tests\Feature\PhotosClientTest;

/**
 * @see PhotosClientTest
 */
class PhotosClient extends JsonPlaceholderClient
{
    /**
     * @param int $photoId
     * @param int $albumId
     *
     * @return ModelResult
     */
    public function setAlbumId(int $photoId, int $albumId): ModelResult
    {
        return $this->setAttribute($photoId, 'albumId', $albumId);
    }

    /**
     * @param int $photoId
     * @param string $title
     *
     * @return ModelResult
     */
    public function setTitle(int $photoId, string $title): ModelResult
    {
        return $this->setAttribute($photoId, 'title', $title);
    }

    /**
     * @param int $photoId
     * @param string $url
     *
     * @return ModelResult
     */
    public function setUrl(int $photoId, string $url): ModelResult
    {
        return $this->setAttribute($photoId, 'url', $url);
    }

    /**
     * @param int $photoId
     * @param string $thumbnailUrl
     *
     * @return ModelResult
     */
    public function setThumbnailUrl(
        int $photoId,
        string $thumbnailUrl
    ): ModelResult {
        return $this->setAttribute($photoId, 'thumbnailUrl', $thumbnailUrl);
    }

    /**
     * @return Model
     */
    protected function getPrototypeModel(): Model
    {
        return new Photo();
    }
}
