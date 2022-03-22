<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Repository;

use App\Core\User\Domain\Entity\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        $user = $entityManager->createQuery(
            'SELECT u
                FROM App\Core\User\Domain\Entity\User u
                WHERE u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();

        return $user;
    }
}
