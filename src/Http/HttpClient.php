<?php

namespace Plelonek\JsonPlaceholder\Http;

use Exception;

class HttpClient implements HttpClientInterface
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var array
     */
    protected $headers;

    /**
     * RESTClient constructor.
     *
     * @param string|null $baseUri
     * @param array $headers
     */
    public function __construct(string $baseUri, array $headers = [])
    {
        $this->baseUri = $baseUri;

        $this->headers = $headers;
    }

    /**
     * @param  Uri  $uri
     * @return HttpResponse
     */
    public function get(Uri $uri): HttpResponse
    {
        return $this->sendRequest($uri, [
            CURLOPT_RETURNTRANSFER  => true,
        ]);
    }

    /**
     * @param Uri $uri
     * @param string $postFields
     * @return HttpResponse
     */
    public function post(Uri $uri, string $postFields): HttpResponse
    {
        return $this->sendRequest($uri, [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $postFields,
        ]);
    }

    /**
     * @param Uri $uri
     * @param string $postFields
     * @return HttpResponse
     */
    public function put(Uri $uri, string $postFields): HttpResponse
    {
        return $this->sendRequest($uri, [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => 'PUT',
            CURLOPT_POSTFIELDS      => $postFields,
        ]);
    }

    /**
     * @param Uri $uri
     * @param string $postFields
     * @return HttpResponse
     */
    public function patch(Uri $uri, string $postFields): HttpResponse
    {
        return $this->sendRequest($uri, [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => 'PATCH',
            CURLOPT_POSTFIELDS      => $postFields,
        ]);
    }

    /**
     * @param Uri $uri
     * @return HttpResponse
     */
    public function delete(Uri $uri): HttpResponse
    {
        return $this->sendRequest($uri, [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => 'DELETE',
        ]);
    }

    /**
     * @param  Uri  $uri
     * @param  array  $options
     * @return HttpResponse
     */
    private function sendRequest(Uri $uri, array $options): HttpResponse
    {
        $curl = curl_init($this->baseUri . $uri->generate());
        $options[CURLOPT_HTTPHEADER] = $this->headers;
        curl_setopt_array($curl, $options);

        try {
            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                $httpResponse = new HttpResponse();
                $httpResponse->setErrorMessage($error);
            } else {
                $httpResponse = new HttpResponse($response);
            }
        } catch (Exception $exception) {
            $httpResponse = new HttpResponse();
            $httpResponse->setErrorMessage($exception->getMessage());
        }

        return $httpResponse;
    }
}
