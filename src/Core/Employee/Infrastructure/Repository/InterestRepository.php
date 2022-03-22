<?php

declare(strict_types=1);

namespace App\Core\Employee\Infrastructure\Repository;

use App\Core\Employee\Domain\Entity\Interest;
use App\Core\Employee\Domain\Repository\InterestRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class InterestRepository extends ServiceEntityRepository implements InterestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interest::class);
    }

    public function save(Interest $interest): void
    {
        $this->_em->persist($interest);
        $this->_em->flush();
    }
}
