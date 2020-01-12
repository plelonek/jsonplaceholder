JSONPlaceholder Client
==========

## Installation

```
composer require plelonek/jsonplaceholder
```

## 🚀 Usage

```php
$postsClient = new PostsClient();

$result = $postsClient->get(1);

if ($result->isSuccess()) {
    $post = $result->getModel();

    echo $post->getAttribute('title');
}
```

## Issues

> [Nested resources are returning all resources](https://github.com/typicode/jsonplaceholder/issues/91)
