<?php

namespace ReactMoreTech\Support\Adapter\Formatter;

use JsonSerializable;

/**
 * API Response Wrapper Class
 */
class Response implements JsonSerializable
{
    private array $response;

    /**
     * Constructor.
     *
     * @param bool $success Status keberhasilan request.
     * @param int $statusCode HTTP Status Code.
     * @param string $message Pesan response.
     * @param mixed $data Data response yang bisa dikustom.
     */
    public function __construct(
        bool $success,
        int $statusCode,
        string $message,
        mixed $data
    ) {
        $this->response = [
            'success' => $success,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data
        ];
    }

    public function toArray(): array
    {
        return $this->response;
    }

    public function jsonSerialize(): mixed
    {
        return $this->response;
    }

    public function toJson(): string
    {
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function __get(string $key): mixed
    {
        return $this->response[$key] ?? null;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
