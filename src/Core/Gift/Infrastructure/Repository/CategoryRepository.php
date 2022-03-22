<?php

declare(strict_types=1);

namespace App\Core\Gift\Infrastructure\Repository;

use App\Core\Gift\Domain\Entity\Category;
use App\Core\Gift\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }
}
