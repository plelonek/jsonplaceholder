<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests\Feature;

use Plelonek\JsonPlaceholder\Models\Photo;
use Plelonek\JsonPlaceholder\PhotosClient;
use Plelonek\JsonPlaceholder\Tests\ClientTestCase;

/**
 * @covers \Plelonek\JsonPlaceholder\PhotosClient
 * @covers \Plelonek\JsonPlaceholder\JsonPlaceholderClient
 */
class PhotosClientTest extends ClientTestCase
{
    /**
     * @var PhotosClient
     */
    private $photosClient;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->photosClient = new PhotosClient();
    }

    /**
     * @return void
     */
    public function testGetAllPhotos(): void
    {
        $collectionResult = $this->photosClient->getAll();

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 5000
        );
    }

    /**
     * @return void
     */
    public function testGetAllFilteredPhotos(): void
    {
        $filteredAlbumId = 1;

        $collectionResult = $this->photosClient->getAll([
            'albumId' => $filteredAlbumId,
            'notFilterableAttribute' => true,
        ]);

        $this->assertTrue($collectionResult->isSuccess());

        foreach ($collectionResult->getCollection() as $photo) {
            /** @var Photo $photo */

            $this->assertSame(
                $photo->getAttribute('albumId'),
                $filteredAlbumId
            );
        }
    }

    /**
     * @return void
     */
    public function testGetPhoto(): void
    {
        $photoId = 1;
        $modelResult = $this->photosClient->get($photoId);

        $this->assertTrue($modelResult->isSuccess());
        $post = $modelResult->getModel();

        $this->assertInstanceOf(Photo::class, $post);
        $this->assertSame($post->getAttribute('id'), $photoId);

        $photoAttributes = $post->getAttributes()->toArray();
        $predictedAttributes = $this->getModelPredictedAttributes($post);

        foreach ($predictedAttributes as $attribute) {
            $this->assertArrayHasKey($attribute, $photoAttributes);
        }
    }

    /**
     * @return void
     */
    public function testCreatePhoto(): void
    {
        $notFillableAttribute = 'notFillableAttribute';

        $data = [
            'albumId' => 1,
            'title' => 'This is a title',
            'url' => 'https://fake.photo.com/600/1',
            'thumbnailUrl' => 'https://fake.photo.com/300/1',
            $notFillableAttribute => 'This is not fillable attribute',
        ];

        $modelResult = $this->photosClient->create($data);
        $photo = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        foreach (['albumId', 'title', 'url', 'thumbnailUrl'] as $attribute) {
            $this->assertSame(
                $photo->getAttribute($attribute), $data[$attribute]
            );
        }

        $this->assertArrayNotHasKey(
            $notFillableAttribute,
            $photo->getAttributes()->toArray()
        );
    }

    /**
     * @return void
     */
    public function testUpdatePhoto(): void
    {
        $photoId = 1;
        $data = [
            'albumId' => 1,
            'title' => 'This is a title',
            'url' => 'https://fake.photo.com/600/1',
            'thumbnailUrl' => 'https://fake.photo.com/300/1',
        ];

        $modelResult = $this->photosClient->update($photoId, $data);
        $photo = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        foreach (['albumId', 'title', 'url', 'thumbnailUrl'] as $attribute) {
            $this->assertSame(
                $photo->getAttribute($attribute), $data[$attribute]
            );
        }

        $this->assertSame($photo->getAttribute('id'), $photoId);
    }

    /**
     * @return void
     */
    public function testDeletePhoto(): void
    {
        $photoId = 1;
        $modelResult = $this->photosClient->delete($photoId);

        $this->assertTrue($modelResult->isSuccess());
        $this->assertNull($modelResult->getModel());
    }

    /**
     * @return void
     */
    public function testSetAlbumId(): void
    {
        $newAlbumId = 2;
        $modelResult = $this->photosClient->setAlbumId(1, $newAlbumId);

        $this->assertTrue($modelResult->isSuccess());

        $photo = $modelResult->getModel();
        $this->assertSame($photo->getAttribute('albumId'), $newAlbumId);
    }

    /**
     * @return void
     */
    public function testSetTitle(): void
    {
        $newTitle = 'This is a new title';
        $modelResult = $this->photosClient->setTitle(1, $newTitle);

        $this->assertTrue($modelResult->isSuccess());

        $photo = $modelResult->getModel();
        $this->assertSame($photo->getAttribute('title'), $newTitle);
    }

    /**
     * @return void
     */
    public function testSetUrl(): void
    {
        $newUrl = 'https://fake.photo.com/600/1';
        $modelResult = $this->photosClient->setUrl(1, $newUrl);

        $this->assertTrue($modelResult->isSuccess());

        $photo = $modelResult->getModel();
        $this->assertSame($photo->getAttribute('url'), $newUrl);
    }

    /**
     * @return void
     */
    public function testSetThumbnailUrl(): void
    {
        $newThumbnailUrl = 'https://fake.photo.com/300/1';
        $modelResult = $this->photosClient->setThumbnailUrl(
            1,
            $newThumbnailUrl
        );

        $this->assertTrue($modelResult->isSuccess());

        $photo = $modelResult->getModel();
        $this->assertSame(
            $photo->getAttribute('thumbnailUrl'),
            $newThumbnailUrl
        );
    }
}
