<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Model;

final class UpdateEmployeeCommand
{
    public function __construct(
        private string $id,
        private string $name,
        private array $interestIds,
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
