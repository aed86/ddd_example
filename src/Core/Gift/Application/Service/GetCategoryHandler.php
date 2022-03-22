<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Service;

use App\Core\Gift\Application\Model\GetCategoryQuery;
use App\Core\Gift\Domain\Entity\Category;
use App\Core\Gift\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GetCategoryHandler implements MessageHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(GetCategoryQuery $getCategoryQuery): Category
    {
        $categoryId = $getCategoryQuery->getCategoryId();

        /** @var Category $category */
        $category = $this->categoryRepository->find($categoryId);

        if ($category === null) {
            // TODO proper exception
            throw new \Exception("category not found");
        }

        if (!$category->isActive()) {
            // TODO proper exception
            throw new \Exception("category inactive");
        }

        return $category;
    }
}
