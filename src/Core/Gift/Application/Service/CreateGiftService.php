<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Service;

use App\Core\Gift\Application\Model\CreateGiftCommand;
use App\Core\Gift\Domain\Entity\Gift;
use App\Core\Gift\Domain\Repository\GiftRepositoryInterface;
use App\Shared\ValueObject\GiftId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateGiftService implements MessageHandlerInterface
{
    public function __construct(
        private GiftRepositoryInterface $giftRepository,
    ) {
    }

    public function __invoke(CreateGiftCommand $createGiftCommand): Gift
    {
        $gift = Gift::create(
            new GiftId(Uuid::uuid4()->toString()),
            $createGiftCommand->getName(),
        );

        $this->giftRepository->save($gift);

        return $gift;
    }
}
