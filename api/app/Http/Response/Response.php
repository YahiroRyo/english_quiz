<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class Response
{
    private int $statusCode;
    private string $message;
    private array $data;

    private function __construct(int $statusCode, string $message, array $data)
    {
        $this->statusCode = $statusCode;
        $this->message    = $message;
        $this->data       = $data;
    }

    private function toJson()
    {
        return new JsonResponse(
            [
                'message' => $this->message,
                'data'    => $this->data
            ],
            $this->statusCode,
        );
    }

    public static function success(string $message, ?array $data = null, int $statusCode = 200): JsonResponse
    {
        if ($data) {
            return (new Response(
                $statusCode,
                $message,
                $data
            ))
            ->toJson();
        }

        return (new Response(
            $statusCode,
            $message,
            []
        ))->toJson();
    }

    public static function error(string $message, ?array $data = null, int $statusCode = 500): JsonResponse
    {
        if ($data) {
            return (new Response(
                $statusCode,
                $message,
                $data
            ))->toJson();
        }

        return (new Response(
            $statusCode,
            $message,
            [],
        ))->toJson();
    }
}
