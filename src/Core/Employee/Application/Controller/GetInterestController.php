<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Controller;

use App\Core\Employee\Application\Model\GetInterestQuery;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/interest/{guid}", name="api_interest_get", methods={"GET"})
 */
final class GetInterestController extends BaseController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $interestId = (string)$request->get("guid");

        $getCategoryQuery = new GetInterestQuery(
            $interestId,
        );

        /** @var \App\Core\Employee\Domain\Entity\Interest $interest */
        $interest = $this->handle($getCategoryQuery);

        return (new JsonResponse)->setData([
            'id' => $interest->getId(),
            'name' => $interest->getName(),
            'createdAt' => $interest->getCreatedAt(),
            'updatedAt' => $interest->getUpdatedAt(),
            'employees' => array_map(static function ($employee) {
                return [
                    'id' => $employee->getId(),
                    'name' => $employee->getName(),
                    'createdAt' => $employee->getCreatedAt(),
                    'updatedAt' => $employee->getUpdatedAt(),
                ];
            }, $interest->getEmployees()->toArray()),
        ]);
    }
}
