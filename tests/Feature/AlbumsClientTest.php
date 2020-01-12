<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests\Feature;

use Plelonek\JsonPlaceholder\AlbumsClient;
use Plelonek\JsonPlaceholder\Models\Album;
use Plelonek\JsonPlaceholder\Models\Photo;
use Plelonek\JsonPlaceholder\Tests\ClientTestCase;

/**
 * @covers \Plelonek\JsonPlaceholder\AlbumsClient
 * @covers \Plelonek\JsonPlaceholder\JsonPlaceholderClient
 */
class AlbumsClientTest extends ClientTestCase
{
    /**
     * @var AlbumsClient
     */
    private $albumsClient;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->albumsClient = new AlbumsClient();
    }

    /**
     * @return void
     */
    public function testGetAllAlbums(): void
    {
        $collectionResult = $this->albumsClient->getAll();

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 100
        );
    }

    /**
     * @return void
     */
    public function testGetAllFilteredAlbums(): void
    {
        $filteredUserId = 1;

        $collectionResult = $this->albumsClient->getAll([
            'userId' => $filteredUserId,
            'notFilterableAttribute' => true,
        ]);

        $this->assertTrue($collectionResult->isSuccess());

        foreach ($collectionResult->getCollection() as $album) {
            /** @var Album $album */

            $this->assertSame(
                $album->getAttribute('userId'),
                $filteredUserId
            );
        }
    }

    /**
     * @return void
     */
    public function testGetAlbum(): void
    {
        $albumId = 1;
        $modelResult = $this->albumsClient->get($albumId);

        $this->assertTrue($modelResult->isSuccess());
        $album = $modelResult->getModel();

        $this->assertInstanceOf(Album::class, $album);
        $this->assertSame($album->getAttribute('id'), $albumId);

        $albumAttributes = $album->getAttributes()->toArray();
        $predictedAttributes = $this->getModelPredictedAttributes($album);

        foreach ($predictedAttributes as $attribute) {
            $this->assertArrayHasKey($attribute, $albumAttributes);
        }
    }

    /**
     * @return void
     */
    public function testCreateAlbum(): void
    {
        $notFillableAttribute = 'notFillableAttribute';

        $data = [
            'userId' => 1,
            'title' => 'This is a title',
            $notFillableAttribute => 'This is not fillable attribute',
        ];

        $modelResult = $this->albumsClient->create($data);

        $this->assertTrue($modelResult->isSuccess());

        $album = $modelResult->getModel();
        $this->assertSame($album->getAttribute('userId'), $data['userId']);
        $this->assertSame($album->getAttribute('title'), $data['title']);

        $this->assertArrayNotHasKey(
            $notFillableAttribute,
            $album->getAttributes()->toArray()
        );
    }

    /**
     * @return void
     */
    public function testUpdateAlbum(): void
    {
        $albumId = 1;
        $data = [
            'userId' => 2,
            'title' => 'This is a new title',
        ];

        $modelResult = $this->albumsClient->update($albumId, $data);
        $album = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());

        $this->assertSame($album->getAttribute('userId'), $data['userId']);
        $this->assertSame($album->getAttribute('title'), $data['title']);
        $this->assertSame($album->getAttribute('id'), $albumId);
    }

    /**
     * @return void
     */
    public function testDeleteAlbum(): void
    {
        $albumId = 1;
        $modelResult = $this->albumsClient->delete($albumId);

        $this->assertTrue($modelResult->isSuccess());
        $this->assertNull($modelResult->getModel());
    }

    /**
     * @return void
     */
    public function testGetPhotos(): void
    {
        $collectionResult = $this->albumsClient->getPhotos(1);

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 5000
        );

        $firstComment = $collectionResult->getCollection()[0];

        $this->assertInstanceOf(Photo::class, $firstComment);
    }

    /**
     * @return void
     */
    public function testSetUserId(): void
    {
        $newUserId = 2;
        $modelResult = $this->albumsClient->setUserId(1, $newUserId);

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
        $modelResult = $this->albumsClient->setTitle(1, $newTitle);

        $this->assertTrue($modelResult->isSuccess());

        $post = $modelResult->getModel();
        $this->assertSame($post->getAttribute('title'), $newTitle);
    }
}
