<?php

namespace App\Controller;

use App\Entity\Project;
use App\Service\BaseApiService;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[AsController]
class ProjectController extends BaseApiService
{
    public string $entity = Project::class;
    public string $rightPostfix = 'project';

    #[Route('/api/projects', name: 'project_create', methods: 'POST')]
    #[OA\Response(
        response: 200,
        description: 'Success. Returns an empty array if deleting was successful',
    )]
    #[OA\Response(
        response: 401,
        description: 'Need to authorize a User. Returns a string with error message',
    )]
    #[OA\Response(
        response: 403,
        description: 'User doesnt have necessary rights. Returns a string with error message',
    )]
    #[OA\Parameter(
        name: 'name',
        description: 'The name of the project',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Projects')]
    public function createProject(): JsonResponse
    {
        return $this->create();
    }

    #[Route('/api/projects', name: 'project_all', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'Success. Returns an array with all projects',
    )]
    #[OA\Response(
        response: 401,
        description: 'Need to authorize a User. Returns a string with error message',
    )]
    #[OA\Response(
        response: 404,
        description: 'There is no projects. Returns a string with error message',
    )]
    #[OA\Tag(name: 'Projects')]
    public function allProjects(): JsonResponse
    {
        return $this->all();
    }

    #[Route('/api/projects/{id}', name: 'project_one', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'Success. Returns an array with the project data',
    )]
    #[OA\Response(
        response: 401,
        description: 'Need to authorize a User. Returns a string with error message',
    )]
    #[OA\Response(
        response: 404,
        description: 'There is no project with given id. Returns a string with error message',
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'The field used to get the project',
        in: 'path',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Projects')]
    public function getOneProject(int $id): JsonResponse
    {
        return $this->one($id);
    }

    #[Route('/api/projects/{id}', name: 'project_update', methods: 'POST')]
    #[OA\Response(
        response: 200,
        description: 'Success. Returns an array with the project data',
    )]
    #[OA\Response(
        response: 401,
        description: 'Need to authorize a User. Returns a string with error message',
    )]
    #[OA\Response(
        response: 403,
        description: 'User doesnt have necessary rights. Returns a string with error message',
    )]
    #[OA\Response(
        response: 404,
        description: 'There is no project with given id. Returns a string with error message',
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'The field used to update the project',
        in: 'path',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Projects')]
    public function updateProject(int $id): JsonResponse
    {
        return $this->update($id);
    }

    #[Route('/api/projects/{id}', name: 'project_delete', methods: 'DELETE')]
    #[OA\Response(
        response: 200,
        description: 'Success. Returns an empty array if deleting was successful',
    )]
    #[OA\Response(
        response: 401,
        description: 'Need to authorize a User. Returns a string with error message',
    )]
    #[OA\Response(
        response: 403,
        description: 'User doesnt have necessary rights. Returns a string with error message',
    )]
    #[OA\Response(
        response: 404,
        description: 'There is no project with given id. Returns a string with error message',
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'The field used to delete needed project',
        in: 'path',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Projects')]
    public function removeProject(int $id): JsonResponse
    {
        return $this->remove($id);
    }
}
