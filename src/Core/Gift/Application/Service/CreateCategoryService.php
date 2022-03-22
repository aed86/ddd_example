<?php

declare(strict_types=1);

namespace App\Core\Gift\Application\Service;

use App\Core\Gift\Application\Model\CreateCategoryCommand;
use App\Core\Gift\Domain\Entity\Category;
use App\Core\Gift\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Gift\Domain\Repository\GiftRepositoryInterface;
use App\Shared\ValueObject\CategoryId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateCategoryService implements MessageHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private GiftRepositoryInterface $giftRepository,
    ) {
    }

    public function __invoke(CreateCategoryCommand $createCategoryCommand): Category
    {
        $category = Category::create(
            new CategoryId(Uuid::uuid4()->toString()),
            $createCategoryCommand->getName(),
        );

        $gifts = $this->giftRepository->findBy(
            ['id' => $createCategoryCommand->getGiftIds()],
            ['id' => 'DESC'],
        );

        foreach ($gifts as $gift) {
            $category->addGift($gift);
        }

        $this->categoryRepository->save($category);

        return $category;
    }
}
