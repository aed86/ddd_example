<?php

declare(strict_types = 1);

namespace App\Core\Employee\Infrastructure\Repository;

use App\Core\Employee\Domain\Entity\Employee;
use App\Core\Employee\Domain\Repository\EmployeeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function save(Employee $employee): void
    {
        $this->_em->persist($employee);
        $this->_em->flush();
    }
}
