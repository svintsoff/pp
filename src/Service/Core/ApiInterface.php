<?php

namespace App\Service\Core;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiInterface
{
    //public function create(): array;
    // public function edit(): array;
    public function remove(int $projectId): JsonResponse;
    // public function all(): array;
    // public function one(): array;
}