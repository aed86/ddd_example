<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Model;

final class CreateEmployeeCommand
{
    public function __construct(
        private string $name,
        private array $interestIds,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getInterestIds(): array
    {
        return $this->interestIds;
    }
}
