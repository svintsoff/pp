<?php

namespace App\Service;

use App\Helper\ResponseHelper;
use App\Service\Core\ApiInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class BaseApiService implements ApiInterface
{
    public string $entity;
    public string $rightPostfix;

    private Request $request;
    private SessionInterface $session;
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RequestStack $requestStack,
        private readonly ResponseHelper $responseHelper
    )
    {
        $this->request    = $this->requestStack->getCurrentRequest();
        $this->session    = $this->request->getSession();
        $this->repository = $this->entityManager->getRepository($this->entity);
    }

    public function remove(): JsonResponse
    {
        $right = 'right_delete_' . $this->rightPostfix;

        if ($this->session->get('logged') != '1') return $this->responseHelper->unauthorized('unauthorized');
        if ($this->session->get($right) != '1') return $this->responseHelper->forbidden('forbidden');

        $id = $this->request->request->get('id');

        $object = $this->repository->find($id);

        if (!$object) return $this->responseHelper->notFound('unknown id');

        $this->entityManager->remove($object);
        $this->entityManager->flush();

        return $this->responseHelper->ok();
    }
}