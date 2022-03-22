<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Model;

final class DeleteInterestCommand
{
    public function __construct(
        private string $interestId,
    ) {
    }

    /**
     * @return string
     */
    public function getInterestId(): string
    {
        return $this->interestId;
    }
}
