<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\GetEmployeeQuery;
use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GetEmployeeHandler implements MessageHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(GetEmployeeQuery $getEmployeeQuery): Employee
    {
        $employeeId = $getEmployeeQuery->getEmployeeId();
        $employee = $this->employeeRepository->findOneBy(['id' => $employeeId]);

        if ($employee === null) {
            // TODO proper exception
            throw new \Exception("employee is not found");
        }

        return $employee;
    }
}
