<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Service;

use App\Core\Gift\Application\Model\GetGiftQuery;
use App\Core\Gift\Domain\Entity\Gift;
use App\Core\Gift\Domain\Repository\GiftRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GetGiftHandler implements MessageHandlerInterface
{
    public function __construct(
        private GiftRepositoryInterface $giftRepository,
    ) {
    }

    public function __invoke(GetGiftQuery $getGiftQuery): Gift
    {
        $categoryId = $getGiftQuery->getGiftId();

        $gift = $this->giftRepository->find($categoryId);

        if ($gift === null) {
            // TODO proper exception
            throw new \Exception("gift not found");
        }

        return $gift;
    }
}
