<?php

namespace App\Service\Core;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiInterface
{
    //public function create(): array;
    public function all(): JsonResponse;
    public function one(int $projectId): JsonResponse;
    // public function edit(): array;
    public function remove(int $projectId): JsonResponse;
}