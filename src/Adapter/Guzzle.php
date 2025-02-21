<?php

namespace ReactMoreTech\Support\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use ReactMoreTech\Support\Adapter\Auth\AuthInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Guzzle HTTP Adapter
 * 
 * This class provides a wrapper around GuzzleHttp client to handle HTTP requests.
 */
class Guzzle implements AdapterInterface
{
    /** @var Client HTTP client instance */
    private $client;

    /** @var array Request headers */
    protected $headers;

    /** @var string Base URI for requests */
    private $baseURI;
    
    /** @var bool SSL verification flag */
    protected $ssl = true;

    /**
     * Constructor.
     *
     * @param AuthInterface $auth Authentication instance providing headers.
     * @param string|null $baseURI Base URI for the API requests.
     */
    public function __construct(AuthInterface $auth, ?string $baseURI = null)
    {
        $this->baseURI = $baseURI ?? 'https://httpbin.org/';
        $this->headers = array_merge($auth->getHeaders(), [
            'Accept' => 'application/x-www-form-urlencoded',
        ]);
        
        $this->initClient();
    }

    /**
     * Initializes the Guzzle client with the current configuration.
     */
    private function initClient(): void
    {
        $this->client = new Client([
            'base_uri' => $this->baseURI,
            'headers'  => $this->headers,
            'verify'   => $this->ssl,
        ]);
    }

    /**
     * Set SSL verification status.
     *
     * @param bool $verify Whether to verify SSL certificates.
     */
    public function setSSL(bool $verify): void
    {
        $this->ssl = $verify;
        $this->initClient();
    }

    /** {@inheritDoc} */
    public function get(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('get', $uri, $data, $headers);
    }

    /** {@inheritDoc} */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('post', $uri, $data, $headers);
    }

    /** {@inheritDoc} */
    public function put(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('put', $uri, $data, $headers);
    }

    /** {@inheritDoc} */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('patch', $uri, $data, $headers);
    }

    /** {@inheritDoc} */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('delete', $uri, $data, $headers);
    }

    /**
 * Sends an HTTP request.
 *
 * @param string $method The HTTP request method (GET, POST, PUT, PATCH, DELETE).
 * @param string $uri The API endpoint URI.
 * @param array $data The request payload.
 * @param array $headers Additional headers for the request.
 * @throws InvalidArgumentException If an invalid HTTP method is specified.
 * @throws RequestException If an error occurs while sending the request.
 * @return ResponseInterface The response from the API.
 */
public function request(string $method, string $uri, array $data = [], array $headers = []): ResponseInterface
{
    $method = strtolower($method);

    if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'], true)) {
        throw new InvalidArgumentException('Invalid HTTP method: ' . $method);
    }

    $headers = array_merge($this->headers, $headers);

    // Ensure Content-Type is set if JSON payload is provided
    if (isset($data['json']) && !isset($headers['Content-Type'])) {
        $headers['Content-Type'] = 'application/json';
    }

    $options = ['headers' => $headers];

    if ($method === 'get') {
        $options['query'] = isset($data['json']) ? $data['json'] : $data;
    } else {
        if (isset($data['json'])) {
            $options['json'] = $data['json'];
        } elseif (isset($data['multipart'])) {
            $options['multipart'] = [];
            foreach ($data['multipart'] as $name => $content) {
                $options['multipart'][] = [
                    'name'     => $name,
                    'contents' => $content,
                ];
            }
        } else {
            $options['form_params'] = $data;
        }
    }

    return $this->client->request($method, $uri, $options);
}

}
