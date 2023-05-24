<?php

namespace App\Service\Core;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiInterface
{
    public function create(): JsonResponse;
    public function all(): JsonResponse;
    public function one(int $projectId): JsonResponse;
    public function update(int $projectId): JsonResponse;
    public function remove(int $projectId): JsonResponse;
}