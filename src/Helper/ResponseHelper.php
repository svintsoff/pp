<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseHelper
{
    public function __construct()
    {
        return $this;
    }

    public function ok(array|string $data = []): JsonResponse
    {
        return new JsonResponse($data, 200);
    }

    public function unauthorized(array|string $data = []): JsonResponse
    {
        return new JsonResponse($data, 401);
    }

    public function forbidden(array|string $data = []): JsonResponse
    {
        return new JsonResponse($data, 403);
    }

    public function notFound(array|string $data = []): JsonResponse
    {
        return new JsonResponse($data, 404);
    }
}