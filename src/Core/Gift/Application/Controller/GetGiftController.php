<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Controller;

use App\Core\Gift\Application\Model\GetGiftQuery;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/gift/{guid}", name="api_gift_get", methods={"GET"})
 */
final class GetGiftController extends BaseController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $giftId = (string)$request->get("guid");

        $getGiftQuery = new GetGiftQuery($giftId);

        /** @var \App\Core\Gift\Domain\Entity\Gift $gift */
        $gift = $this->handle($getGiftQuery);

        return (new JsonResponse)->setData([
            'id' => $gift->getId(),
            'name' => $gift->getName(),
            'createdAt' => $gift->getCreatedAt(),
            'updatedAt' => $gift->getUpdatedAt(),
            'categories' => array_map(static function ($category) {
                return [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'createdAt' => $category->getCreatedAt(),
                    'updatedAt' => $category->getUpdatedAt(),
                ];
            }, $gift->getCategories()->toArray()),
        ]);
    }
}
