<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\UpdateEmployeeCommand;
use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use App\Shared\ValueObject\EmployeeId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateEmployeeService implements MessageHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private InterestRepositoryInterface $interestRepository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(UpdateEmployeeCommand $updateEmployeeCommand): Employee
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->findOneBy(['id' => $updateEmployeeCommand->getId()]);
        if ($employee === null) {
            throw new \Exception("Employee not found");
        }

        $employee->setName($updateEmployeeCommand->getName());
        if (count($updateEmployeeCommand->getInterestIds()) > 0) {
            foreach ($employee->getInterests() as $i) {
                if (!in_array($i, $updateEmployeeCommand->getInterestIds(), true)) {
                    $employee->removeInterest($i);
                }
            }

            $interests = $this->interestRepository->findBy(
                ['id' => $updateEmployeeCommand->getInterestIds()],
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
