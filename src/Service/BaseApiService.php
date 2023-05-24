<?php

namespace App\Service;

use App\Helper\ResponseHelper;
use App\Service\Core\ApiInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class BaseApiService implements ApiInterface
{
    public string $entity;
    public string $rightPostfix;

    private SessionInterface $session;
    private EntityRepository $repository;

    private array $normalizers;
    private Serializer $serializer;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RequestStack           $requestStack,
        private readonly ResponseHelper         $responseHelper,
    )
    {
        $this->session = $this->requestStack->getCurrentRequest()->getSession();
        $this->repository = $this->entityManager->getRepository($this->entity);

        $this->normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($this->normalizers, []);
    }

    public function all(): JsonResponse
    {
        // if ($this->session->get('logged') != '1') return $this->responseHelper->unauthorized('unauthorized');

        $objects = $this->repository->findAll();

        if (!$objects) return $this->responseHelper->notFound('no data');

        $data = $this->serializer->normalize($objects);

        return $this->responseHelper->ok($data);
    }

    public function one(int $projectId): JsonResponse
    {
        if ($this->session->get('logged') != '1') return $this->responseHelper->unauthorized('unauthorized');

        $object = $this->repository->find($projectId);

        if (!$object) return $this->responseHelper->notFound('unknown id');

        $data = $this->serializer->normalize($object);

        return $this->responseHelper->ok($data);
    }

    public function remove(int $projectId): JsonResponse
    {
        $right = 'right_delete_' . $this->rightPostfix;

        if ($this->session->get('logged') != '1') return $this->responseHelper->unauthorized('unauthorized');
        if ($this->session->get($right) != '1') return $this->responseHelper->forbidden('forbidden');

        $object = $this->repository->find($projectId);

        if (!$object) return $this->responseHelper->notFound('unknown id');

        $this->entityManager->remove($object);
        $this->entityManager->flush();

        return $this->responseHelper->ok();
    }
}