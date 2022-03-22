<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\DeleteInterestCommand;
use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteCategoryService implements MessageHandlerInterface
{
    public function __construct(
        private InterestRepositoryInterface $interestRepository,
    ) {
    }

    public function __invoke(DeleteInterestCommand $deleteInterestCommand): void
    {
        /** @var Interest $interest */
        $interest = $this->interestRepository->findOneBy(['id' => $deleteInterestCommand->getInterestId()]);
        $interest->setActive(false);
        $this->interestRepository->save($interest);
    }
}
