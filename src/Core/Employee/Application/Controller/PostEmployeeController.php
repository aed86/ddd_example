<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Controller;

use App\Core\Employee\Application\Model\CreateEmployeeCommand;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/employee/", name="api_employee_post", methods={"POST"})
 */
final class PostEmployeeController extends BaseController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $parameters = json_decode(
            $request->getContent(),
            true, 512,
            JSON_THROW_ON_ERROR
        );

        $createEmployeeCommand = new CreateEmployeeCommand(
            $parameters['name'],
            $parameters['interestIds'] ?? [],
        );

        /** @var \App\Core\Employee\Domain\Entity\Employee $employee */
        $employee = $this->handle($createEmployeeCommand);

        return (new JsonResponse())->setData([
            'id' => $employee->getId(),
            'name' => $employee->getName(),
            'createdAt' => $employee->getCreatedAt(),
            'updatedAt' => $employee->getUpdatedAt(),
            'interests' => array_map(static function ($interest) {
                return [
                    'id' => $interest->getId(),
                    'name' => $interest->getName(),
                    'createdAt' => $interest->getCreatedAt(),
                    'updatedAt' => $interest->getUpdatedAt(),
                ];
            }, $employee->getInterests()->toArray()),
        ]);
    }
}
