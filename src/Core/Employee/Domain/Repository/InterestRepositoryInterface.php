<?php

declare(strict_types = 1);

namespace App\Core\Employee\Domain\Repository;

use App\Core\Employee\Domain\Entity\Interest;

interface InterestRepositoryInterface
{
    public function findOneBy(array $criteria, array $orderBy = null);

    public function save(Interest $interest): void;
}
