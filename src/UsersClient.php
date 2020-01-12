<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder;

use Plelonek\JsonPlaceholder\Http\SimpleUri;
use Plelonek\JsonPlaceholder\Models\Album;
use Plelonek\JsonPlaceholder\Models\Model;
use Plelonek\JsonPlaceholder\Models\Post;
use Plelonek\JsonPlaceholder\Models\Todo;
use Plelonek\JsonPlaceholder\Models\User;
use Plelonek\JsonPlaceholder\Tests\Feature\UsersClientTest;

/**
 * @see UsersClientTest
 */
class UsersClient extends JsonPlaceholderClient
{
    /**
     * @param int $userId
     *
     * @return CollectionResult
     */
    public function getPosts(int $userId): CollectionResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/${userId}/posts")
        );

        return new CollectionResult($httpResponse, new Post());
    }

    /**
     * @param int $userId
     *
     * @return CollectionResult
     */
    public function getAlbums(int $userId): CollectionResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/${userId}/albums")
        );

        return new CollectionResult($httpResponse, new Album());
    }

    /**
     * @param int $userId
     *
     * @return CollectionResult
     */
    public function getTodos(int $userId): CollectionResult
    {
        $httpResponse = $this->http->get(
            new SimpleUri("/${userId}/todos")
        );

        return new CollectionResult($httpResponse, new Todo());
    }

    /**
     * @param int $userId
     * @param string $name
     *
     * @return ModelResult
     */
    public function setName(int $userId, string $name): ModelResult
    {
        return $this->setAttribute($userId, 'name', $name);
    }

    /**
     * @param int $userId
     * @param string $username
     *
     * @return ModelResult
     */
    public function setUsername(int $userId, string $username): ModelResult
    {
        return $this->setAttribute($userId, 'username', $username);
    }

    /**
     * @param int $userId
     * @param string $email
     *
     * @return ModelResult
     */
    public function setEmail(int $userId, string $email): ModelResult
    {
        return $this->setAttribute($userId, 'email', $email);
    }

    /**
     * @param int $userId
     * @param string $phone
     *
     * @return ModelResult
     */
    public function setPhone(int $userId, string $phone): ModelResult
    {
        return $this->setAttribute($userId, 'phone', $phone);
    }

    /**
     * @param int $userId
     * @param string $website
     *
     * @return ModelResult
     */
    public function setWebsite(int $userId, string $website): ModelResult
    {
        return $this->setAttribute($userId, 'website', $website);
    }

    /**
     * @param int $userId
     * @param array $address
     *
     * @return ModelResult
     */
    public function setAddress(int $userId, array $address): ModelResult
    {
        return $this->setAttribute($userId, 'address', $address);
    }

    /**
     * @param int $userId
     * @param array $company
     *
     * @return ModelResult
     */
    public function setCompany(int $userId, array $company): ModelResult
    {
        return $this->setAttribute($userId, 'company', $company);
    }

    /**
     * @return Model
     */
    protected function getPrototypeModel(): Model
    {
        return new User();
    }
}
