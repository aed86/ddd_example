<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Model;

final class GetEmployeeQuery
{
    private string $employeeId;

    public function __construct(string $employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }
}
