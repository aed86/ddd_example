<?php

declare(strict_types=1);

namespace App\Core\Gift\Application\Model;

final class GetCategoryQuery
{
    private string $categoryId;

    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}
