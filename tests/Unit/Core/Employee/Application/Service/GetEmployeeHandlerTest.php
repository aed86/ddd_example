<?php

namespace App\Tests\Unit\Core\Employee\Application\Service;

use App\Core\Employee\Application\Model\GetEmployeeQuery;
use App\Core\Employee\Application\Service\GetEmployeeHandler;
use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Shared\ValueObject\EmployeeId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetEmployeeHandlerTest extends TestCase
{

    public function testGetEmployeeHandler_Success(): void
    {
        $employeeRepository = $this->createMock(EmployeeRepositoryInterface::class);
//        $interestRepository = $this->createMock(InterestRepositoryInterface::class);
        $service = new GetEmployeeHandler($employeeRepository);

        $employee = Employee::create(
            new EmployeeId(Uuid::uuid4()->toString()),
            "test employee",
        );
        $query = new GetEmployeeQuery($employee->getId());

        $employeeRepository->method('findOneBy')->willReturn($employee);

        $result = $service($query);

        $this->assertEquals($employee, $result);
    }

    public function testGetEmployeeHandler_NotFoundException(): void
    {
        $this->expectException(\Exception::class);

        $employeeRepository = $this->createMock(EmployeeRepositoryInterface::class);
        $service = new GetEmployeeHandler($employeeRepository);

        $employee = Employee::create(
            new EmployeeId(Uuid::uuid4()->toString()),
            "test employee 2",
        );

        $employeeRepository->method('findOneBy')->willReturn(null);

        $query = new GetEmployeeQuery($employee->getId());
        $service($query);

    }
}
