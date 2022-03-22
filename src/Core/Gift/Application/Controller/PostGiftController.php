<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Controller;

use App\Core\Gift\Application\Model\CreateGiftCommand;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/gift/", name="api_gift_post", methods={"POST"})
 */
final class PostGiftController extends BaseController
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

        $createGiftCommand = new CreateGiftCommand(
            $parameters['name']
        );

        /** @var \App\Core\Gift\Domain\Entity\Gift $gift */
        $gift = $this->handle($createGiftCommand);

        return (new JsonResponse())->setData([
            'id' => $gift->getId(),
            'name' => $gift->getName(),
        ]);
    }
}
