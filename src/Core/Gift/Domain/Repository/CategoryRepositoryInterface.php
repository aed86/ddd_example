<?php

declare(strict_types = 1);

namespace App\Core\Gift\Domain\Repository;

use App\Core\Gift\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save(Category $category): void;
}
