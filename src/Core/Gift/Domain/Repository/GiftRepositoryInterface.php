<?php

declare(strict_types = 1);

namespace App\Core\Gift\Domain\Repository;

use App\Core\Gift\Domain\Entity\Gift;

interface GiftRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save(Gift $gift): void;
}
