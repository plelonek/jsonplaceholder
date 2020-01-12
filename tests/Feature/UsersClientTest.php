<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Tests\Feature;

use Plelonek\JsonPlaceholder\Models\Album;
use Plelonek\JsonPlaceholder\Models\Post;
use Plelonek\JsonPlaceholder\Models\Todo;
use Plelonek\JsonPlaceholder\Models\User;
use Plelonek\JsonPlaceholder\Tests\ClientTestCase;
use Plelonek\JsonPlaceholder\UsersClient;

/**
 * @covers \Plelonek\JsonPlaceholder\UsersClient
 * @covers \Plelonek\JsonPlaceholder\JsonPlaceholderClient
 */
class UsersClientTest extends ClientTestCase
{
    /**
     * @var UsersClient
     */
    private $usersClient;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->usersClient = new UsersClient();
    }

    /**
     * @return void
     */
    public function testGetAllUsers(): void
    {
        $collectionResult = $this->usersClient->getAll();

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 10
        );
    }

    /**
     * @return void
     */
    public function testGetAllFilteredUsers(): void
    {
        $filteredName = 'Leanne Graham';
        $filteredUsername = 'Bret';

        $collectionResult = $this->usersClient->getAll([
            'name' => $filteredName,
            'username' => $filteredUsername,
            'notFilterableAttribute' => true,
        ]);

        $this->assertTrue($collectionResult->isSuccess());

        foreach ($collectionResult->getCollection() as $user) {
            /** @var User $user */

            $this->assertSame(
                $user->getAttribute('name'),
                $filteredName
            );

            $this->assertSame(
                $user->getAttribute('username'),
                $filteredUsername
            );
        }
    }

    /**
     * @return void
     */
    public function testGetUser(): void
    {
        $userId = 1;
        $modelResult = $this->usersClient->get($userId);

        $this->assertTrue($modelResult->isSuccess());
        $user = $modelResult->getModel();

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($user->getAttribute('id'), $userId);

        $userAttributes = $user->getAttributes()->toArray();
        $predictedAttributes = $this->getModelPredictedAttributes($user);

        foreach ($predictedAttributes as $attribute) {
            $this->assertArrayHasKey($attribute, $userAttributes);
        }
    }

    /**
     * @return void
     */
    public function testCreateUser(): void
    {
        $notFillableAttribute = 'notFillableAttribute';

        $data = [
            'name' => 'Fake Name',
            'username' => 'FakeName',
            'email' => 'fake@email.test',
            'address' => $this->getFakeAddress(),
            'phone' => '123-456-789',
            'website' => 'fakewebsite.com',
            'company' => $this->getFakeCompany(),
            $notFillableAttribute => 'This is not fillable attribute',
        ];

        $modelResult = $this->usersClient->create($data);

        /** @var User $user */
        $user = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());
        $this->assertSameAttributes($user, $data);

        $this->assertArrayNotHasKey(
            $notFillableAttribute,
            $user->getAttributes()->toArray()
        );
    }

    /**
     * @return void
     */
    public function testUpdateUser(): void
    {
        $userId = 1;
        $data = [
            'name' => 'Fake Name',
            'username' => 'FakeName',
            'email' => 'fake@email.test',
            'address' => $this->getFakeAddress(),
            'phone' => '123-456-789',
            'website' => 'fakewebsite.com',
            'company' => $this->getFakeCompany(),
        ];

        $modelResult = $this->usersClient->update($userId, $data);

        /** @var User $user */
        $user = $modelResult->getModel();

        $this->assertTrue($modelResult->isSuccess());
        $this->assertSameAttributes($user, $data);
        $this->assertSame($user->getAttribute('id'), $userId);
    }

    /**
     * @return void
     */
    public function testDeleteUser(): void
    {
        $userId = 1;
        $modelResult = $this->usersClient->delete($userId);

        $this->assertTrue($modelResult->isSuccess());
        $this->assertNull($modelResult->getModel());
    }

    /**
     * @return void
     */
    public function testGetPosts(): void
    {
        $collectionResult = $this->usersClient->getPosts(1);

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 100
        );

        $firstPost = $collectionResult->getCollection()[0];

        $this->assertInstanceOf(Post::class, $firstPost);
    }

    /**
     * @return void
     */
    public function testGetAlbums(): void
    {
        $collectionResult = $this->usersClient->getAlbums(1);

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 100
        );

        $firstAlbum = $collectionResult->getCollection()[0];

        $this->assertInstanceOf(Album::class, $firstAlbum);
    }

    /**
     * @return void
     */
    public function testGetTodos(): void
    {
        $collectionResult = $this->usersClient->getTodos(1);

        $this->assertTrue($collectionResult->isSuccess());
        $this->assertSame(
            $collectionResult->getCollection()->count(), 200
        );

        $firstTodo = $collectionResult->getCollection()[0];

        $this->assertInstanceOf(Todo::class, $firstTodo);
    }

    /**
     * @return void
     */
    public function testSetName(): void
    {
        $newName = 'Fake Name';
        $modelResult = $this->usersClient->setName(1, $newName);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $this->assertSame($user->getAttribute('name'), $newName);
    }

    /**
     * @return void
     */
    public function testSetUsername(): void
    {
        $newUsername = 'FakeUsername';
        $modelResult = $this->usersClient->setUsername(1, $newUsername);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $this->assertSame($user->getAttribute('username'), $newUsername);
    }

    /**
     * @return void
     */
    public function testSetEmail(): void
    {
        $email = 'fake@email.test';
        $modelResult = $this->usersClient->setEmail(1, $email);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $this->assertSame($user->getAttribute('email'), $email);
    }

    /**
     * @return void
     */
    public function testSetPhone(): void
    {
        $phone = '123-456-789';
        $modelResult = $this->usersClient->setPhone(1, $phone);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $this->assertSame($user->getAttribute('phone'), $phone);
    }

    /**
     * @return void
     */
    public function testSetWebsite(): void
    {
        $website = 'fakewebsite.com';
        $modelResult = $this->usersClient->setWebsite(1, $website);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $this->assertSame($user->getAttribute('website'), $website);
    }

    /**
     * @return void
     */
    public function testSetAddress(): void
    {
        $address = $this->getFakeAddress();
        $modelResult = $this->usersClient->setAddress(1, $address);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $userModelArray = $user->toArray();

        $this->assertSame($userModelArray['address'], $address);
    }

    /**
     * @return void
     */
    public function testSetCompany(): void
    {
        $company = $this->getFakeCompany();
        $modelResult = $this->usersClient->setCompany(1, $company);

        $this->assertTrue($modelResult->isSuccess());

        $user = $modelResult->getModel();
        $userModelArray = $user->toArray();

        $this->assertSame($userModelArray['company'], $company);
    }

    /**
     * @param User $user
     * @param array $data
     *
     * @return void
     */
    private function assertSameAttributes(User $user, array $data): void
    {
        $attributes = [
            'name', 'username', 'email', 'phone', 'website',
        ];

        foreach ($attributes as $attribute) {
            $this->assertSame(
                $user->getAttribute($attribute), $data[$attribute]
            );
        }

        $userModelArray = $user->toArray();

        foreach (['address', 'company'] as $attribute) {
            $this->assertSame(
                $userModelArray[$attribute], $data[$attribute]
            );
        }
    }

    /**
     * @return array
     */
    private function getFakeAddress(): array
    {
        return [
            'street' => 'Fake Street',
            'suite' => 'Apt. 537',
            'city' => 'Fake City',
            'zipcode' => '12-345',
            'geo' => [
                'lat' => '-37.3159',
                'lng' => '81.1496',
            ],
        ];
    }

    /**
     * @return array
     */
    private function getFakeCompany(): array
    {
        return [
            'name' => 'Fake company',
            'catchPhrase' => 'Fake phrase',
            'bs' => 'Fake bs',
        ];
    }
}
