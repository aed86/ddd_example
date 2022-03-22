<?php

declare(strict_types = 1);

namespace App\Core\Gift\Infrastructure\Repository;

use App\Core\Gift\Domain\Entity\Gift;
use App\Core\Gift\Domain\Repository\GiftRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class GiftRepository extends ServiceEntityRepository implements GiftRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gift::class);
    }

    public function save(Gift $gift): void
    {
        $this->_em->persist($gift);
        $this->_em->flush();
    }
}
