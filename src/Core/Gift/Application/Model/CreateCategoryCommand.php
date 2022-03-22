<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Model;

final class CreateCategoryCommand
{
    public function __construct(
        private string $name,
        private array $giftIds,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getGiftIds(): array
    {
        return $this->giftIds;
    }
}
