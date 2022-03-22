<?php

declare(strict_types = 1);

namespace App\Core\Employee\Domain\Repository;

use App\Core\Employee\Domain\Entity\Employee;

interface EmployeeRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save(Employee $employee): void;
}
