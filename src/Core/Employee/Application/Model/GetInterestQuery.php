<?php

declare(strict_types = 1);

namespace App\Core\Employee\Application\Model;

final class GetInterestQuery
{
    private string $interestId;

    public function __construct(string $interestId)
    {
        $this->interestId = $interestId;
    }

    public function getInterestId(): string
    {
        return $this->interestId;
    }
}
