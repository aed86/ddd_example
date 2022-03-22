<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\CreateInterestCommand;
use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use App\Shared\ValueObject\InterestId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateInterestService implements MessageHandlerInterface
{
    public function __construct(
        private InterestRepositoryInterface $interestRepository,
        private EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    public function __invoke(CreateInterestCommand $createInterestCommand): Interest
    {
        $interest = Interest::create(
            new InterestId(Uuid::uuid4()->toString()),
            $createInterestCommand->getName(),
        );

        if (count($createInterestCommand->getEmployeeIds()) > 0) {
            $employees = $this->employeeRepository->findBy(
                ['id' => $createInterestCommand->getEmployeeIds()],
                ['updatedAt' => 'DESC'],
            );

            foreach ($employees as $employee) {
                $interest->addEmployees($employee);
            }
        }

        $this->interestRepository->save($interest);

        return $interest;
    }
}
