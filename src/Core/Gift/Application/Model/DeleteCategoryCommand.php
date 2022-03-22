<?php

declare(strict_types = 1);

namespace App\Core\Gift\Application\Model;

final class DeleteCategoryCommand
{
    public function __construct(
        private string $categoryId,
    ) {
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}
