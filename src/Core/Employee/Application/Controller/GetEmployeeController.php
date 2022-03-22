<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Controller;

use App\Core\Employee\Application\Model\GetEmployeeQuery;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/employee/{guid}", name="api_employee_get", methods={"GET"})
 */
final class GetEmployeeController extends BaseController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $id = (string)$request->get("guid");

        $query = new GetEmployeeQuery($id);

        /** @var \App\Core\Employee\Domain\Entity\Employee $entity */
        $entity = $this->handle($query);

        return (new JsonResponse)->setData([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'createdAt' => $entity->getCreatedAt(),
            'updatedAt' => $entity->getUpdatedAt(),
            'interests' => array_map(static function ($interest) {
                return [
                    'id' => $interest->getId(),
                    'name' => $interest->getName(),
                    'createdAt' => $interest->getCreatedAt(),
                    'updatedAt' => $interest->getUpdatedAt(),
                ];
            }, $entity->getInterests()->toArray()),
        ]);
    }
}
