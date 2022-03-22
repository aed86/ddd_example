<?php

declare(strict_types=1);

namespace App\Core\Gift\Application\Model;

final class CreateGiftCommand
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
