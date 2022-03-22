<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\GetInterestQuery;
use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GetInterestHandler implements MessageHandlerInterface
{
    public function __construct(
        private InterestRepositoryInterface $interestRepository,
    ) {
    }

    public function __invoke(GetInterestQuery $getInterestQuery): Interest
    {
        $interestId = $getInterestQuery->getInterestId();

        /** @var Interest $interest */
        $interest = $this->interestRepository->find($interestId);

        if ($interest === null) {
            // TODO proper exception
            throw new \Exception("interest not found");
        }

        if (!$interest->isActive()) {
            // TODO proper exception
            throw new \Exception("interest is inactive");
        }

        return $interest;
    }
}
