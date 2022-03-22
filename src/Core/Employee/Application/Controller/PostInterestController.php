<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Controller;

use App\Core\Employee\Application\Model\CreateInterestCommand;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/interest/", name="api_interest_post", methods={"POST"})
 */
final class PostInterestController extends BaseController
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

        $createInterestCommand = new CreateInterestCommand(
            $parameters['name'],
            $parameters['employeeIds'] ?? [],
        );

        /** @var \App\Core\Employee\Domain\Entity\Interest $interest */
        $interest = $this->handle($createInterestCommand);

        return (new JsonResponse())->setData([
            'id' => $interest->getId(),
            'name' => $interest->getName(),
            'createdAt' => $interest->getCreatedAt(),
            'updatedAt' => $interest->getUpdatedAt(),
        ]);
    }
}
