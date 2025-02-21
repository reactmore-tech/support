<?php

namespace Tests\Adapter;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;
use ReactMoreTech\Support\Adapter\Guzzle;
use ReactMoreTech\Support\Adapter\Auth\BearerToken;

class GuzzleTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Menggunakan BearerToken untuk autentikasi
        $auth = new BearerToken('test-token');
        $this->client = new Guzzle($auth, 'https://httpbin.org/');
    }

    public function testGet()
    {
        $response = $this->client->get('https://httpbin.org/get', [], ['X-Testing' => 'Test']);
        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody());
        $this->assertEquals('Test', $body->headers->{'X-Testing'});
        $this->assertEquals('Bearer test-token', $body->headers->Authorization);

        $response = $this->client->get('https://httpbin.org/get', [], ['X-Another-Test' => 'Test2']);
        $body = json_decode($response->getBody());
        $this->assertEquals('Test2', $body->headers->{'X-Another-Test'});
    }

    public function testPost()
    {
        $response = $this->client->post('https://httpbin.org/post', ['X-Post-Test' => 'Testing a POST request.']);
        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals('Testing a POST request.', $body->form->{'X-Post-Test'});
    }

    public function testPut()
    {
        $response = $this->client->put('https://httpbin.org/put', ['X-Put-Test' => 'Testing a PUT request.']);
        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals('Testing a PUT request.', $body->form->{'X-Put-Test'});
    }

    public function testPatch()
    {
        $response = $this->client->patch(
            'https://httpbin.org/patch',
            ['X-Patch-Test' => 'Testing a PATCH request.']
        );

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals('Testing a PATCH request.', $body->form->{'X-Patch-Test'});
    }

    public function testDelete()
    {
        $response = $this->client->delete(
            'https://httpbin.org/delete',
            ['X-Delete-Test' => 'Testing a DELETE request.']
        );

        $headers = $response->getHeaders();
        $this->assertEquals('application/json', $headers['Content-Type'][0]);

        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals('Testing a DELETE request.', $body->form->{'X-Delete-Test'});
    }

    public function testNotFound()
    {
        $this->expectException(RequestException::class);
        $this->client->get('https://httpbin.org/status/404');
    }

    public function testServerError()
    {
        $this->expectException(RequestException::class);
        $this->client->get('https://httpbin.org/status/500');
    }
}
