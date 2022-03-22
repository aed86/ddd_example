<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Controller;

use App\Core\Gift\Application\Model\GetCategoryQuery;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category/{guid}", name="api_category_get", methods={"GET"})
 */
final class GetCategoryController extends BaseController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $categoryId = (string)$request->get("guid");

        $getCategoryQuery = new GetCategoryQuery(
            $categoryId,
        );

        /** @var \App\Core\Gift\Domain\Entity\Category $category */
        $category = $this->handle($getCategoryQuery);

        return (new JsonResponse)->setData([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'createdAt' => $category->getCreatedAt(),
            'updatedAt' => $category->getUpdatedAt(),
            'gifts' => array_map(static function ($gift) {
                return [
                    'id' => $gift->getId(),
                    'name' => $gift->getName(),
                    'createdAt' => $gift->getCreatedAt(),
                    'updatedAt' => $gift->getUpdatedAt(),
                ];
            }, $category->getGifts()->toArray()),
        ]);
    }
}
