<?php

declare(strict_types=1);

namespace App\Shared\Aggregate;

abstract class AggregateRoot
{
    protected array $domainEvents;
}
