<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\CreateEmployeeCommand;
use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use App\Shared\ValueObject\EmployeeId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateEmployeeService implements MessageHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private InterestRepositoryInterface $interestRepository,
    ) {
    }

    public function __invoke(CreateEmployeeCommand $createEmployeeCommand): Employee
    {
        $employee = Employee::create(
            new EmployeeId(Uuid::uuid4()->toString()),
            $createEmployeeCommand->getName(),
        );

        if (count($createEmployeeCommand->getInterestIds()) > 0) {
            $interests = $this->interestRepository->findBy(
                ['id' => $createEmployeeCommand->getInterestIds()],
                ['updatedAt' => 'DESC'],
            );
            foreach ($interests as $interest) {
                $employee->addInterest($interest);
            }
        }

        $this->employeeRepository->save($employee);

        return $employee;
    }
}
