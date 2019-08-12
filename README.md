JSONPlaceholder Client
==========

## Installation

```
composer require plelonek/jsonplaceholder
```

## Usage

```php
$postsClient = new PostsClient();

$result = $postsClient->get(1);

if ($result->isSuccess()) {
    $post = $result->getModel();

    echo $post->getAttribute('title');
}
```

#### PostsClient methods

```php
/**
 * Get the specified post
 */
get(int $postId): ModelResult

/**
 * Get all posts, or those matching allowed filters
 */
getAll(array $filters = []): CollectionResult

/**
 * Create new post
 */
create(array $attributes): ModelResult

/**
 * Update the specified post with allowed attributes
 */
update(int $postId, array $attributes): ModelResult

/**
 * Delete the specified post
 */
delete(int $postId): ModelResult

/**
 * Get comments from specified post (watch issue below)
 */
getComments(int $postId): CollectionResult

/**
 * Set "userId" attribute of specified post
 */
setUserId(int $postId, int $userId): ModelResult

/**
 * Set "title" attribute of specified post
 */
setTitle(int $postId, string $title): ModelResult

/**
 * Set "body" attribute of specified post
 */
setBody(int $postId, string $body): ModelResult
```

## Issues

> [Nested resources are returning all resources](https://github.com/typicode/jsonplaceholder/issues/91)
