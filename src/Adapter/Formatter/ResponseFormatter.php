<?php

namespace ReactMoreTech\Support\Adapter\Formatter;

class ResponseFormatter
{
    /**
     * Format response dari API dengan opsi custom data.
     *
     * @param string $responseBody
     * @param string|null $message
     * @param callable|null $dataFilter Callback function untuk memfilter data API.
     * @return Response
     */
    public static function formatResponse($responseBody, $message = null, callable $dataFilter = null): Response
    {
        $response = json_decode($responseBody, true);
        $data = $response ?? null;

        // Jika ada callback filter, gunakan filter tersebut untuk mengubah data
        if ($dataFilter && is_callable($dataFilter)) {
            $data = call_user_func($dataFilter, $data);
        }

        return new Response(
            success: true,
            statusCode: $response['statusCode'] ?? 200,
            message: $response['messages'] ?? ($message ?? 'Request berhasil'),
            data: $data
        );
    }

    /**
     * Format error response
     *
     * @param string $message
     * @param int $statusCode
     * @return Response
     */
    public static function formatErrorResponse($message, $statusCode = 500): Response
    {
        return new Response(
            success: false,
            statusCode: $statusCode,
            message: $message,
            data: null
        );
    }
}
