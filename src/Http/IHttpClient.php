<?php

declare(strict_types=1);

namespace Plelonek\JsonPlaceholder\Http;

interface IHttpClient
{
    /**
     * @param  Uri  $uri
     *
     * @return HttpResponse
     */
    public function get(Uri $uri): HttpResponse;

    /**
     * @param  Uri  $uri
     * @param $postFields
     *
     * @return HttpResponse
     */
    public function post(Uri $uri, string $postFields): HttpResponse;

    /**
     * @param Uri $uri
     * @param string $postFields
     *
     * @return HttpResponse
     */
    public function put(Uri $uri, string $postFields): HttpResponse;

    /**
     * @param Uri $uri
     * @param string $postFields
     *
     * @return HttpResponse
     */
    public function patch(Uri $uri, string $postFields): HttpResponse;

    /**
     * @param Uri $uri
     *
     * @return HttpResponse
     */
    public function delete(Uri $uri): HttpResponse;
}
