<?php

declare(strict_types = 1);

namespace App\Tests\Functional\Core\Employee\Infrastructure\Repository;

use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Shared\ValueObject\EmployeeId;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmployeeRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private EmployeeRepositoryInterface $repository;

    public function testSave(): void
    {
        $employee = Employee::create(
            new EmployeeId(Uuid::uuid4()->toString()),
            "test employee",
        );

        $this->repository->save($employee);
        /** @var Employee $result */
        $result = $this->repository->findOneBy(['id' => $employee->getId()]);
        $this->assertNotEmpty($result, "employee should not be empty");
        $this->assertEquals($employee, $result, "result is not equal");
    }

    public function testFindBy(): void
    {
        $employee = Employee::create(
            new EmployeeId(Uuid::uuid4()->toString()),
            "test employee",
        );

        $this->repository->save($employee);
        $result = $this->repository->findOneBy(['id' => $employee->getId()]);

        $this->assertEquals($employee->getName(), $result->getName(), "wrong name");
        $this->assertCount(0, $employee->getInterests()->toArray(), "wrong interests");
    }


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = $this->entityManager->getRepository(Employee::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
