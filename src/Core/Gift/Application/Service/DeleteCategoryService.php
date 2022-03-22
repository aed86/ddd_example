<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Service;

use App\Core\Gift\Application\Model\DeleteCategoryCommand;
use App\Core\Gift\Domain\Entity\Category;
use App\Core\Gift\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteCategoryService implements MessageHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(DeleteCategoryCommand $deleteCategoryCommand): void
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['id' => $deleteCategoryCommand->getCategoryId()]);

        $category->setActive(false);
        $this->categoryRepository->save($category);
    }
}
