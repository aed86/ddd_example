<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Controller;

use App\Core\Gift\Application\Model\DeleteCategoryCommand;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category/", name="api_category_delete", methods={"DELETE"})
 */
final class DeleteCategoryController extends BaseController
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

        $createCategoryCommand = new DeleteCategoryCommand(
            $parameters['id'],
        );

        $this->handle($createCategoryCommand);

        return (new JsonResponse())->setData(['success' => true]);
    }
}
