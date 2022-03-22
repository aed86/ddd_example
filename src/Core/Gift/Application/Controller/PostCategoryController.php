<?php

declare(strict_types=1);

namespace App\Core\Gift\Application\Controller;

use App\Core\Gift\Application\Model\CreateCategoryCommand;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category/", name="api_category_post", methods={"POST"})
 */
final class PostCategoryController extends BaseController
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

        $createCategoryCommand = new CreateCategoryCommand(
            $parameters['name'],
            $parameters['giftIds'] ?? [],
        );

        $category = $this->handle($createCategoryCommand);

        return (new JsonResponse())->setData([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'gifts' => array_map(static function ($gift) {
                return [
                    'id' => $gift->getId(),
                    'name' => $gift->getName(),
                ];
            }, $category->getGifts()->toArray()),
        ]);
    }
}
