<?php

declare(strict_types=1);

namespace App\Core\User\Application\Service;

use App\Core\User\Domain\Entity\Email;
use App\Core\User\Domain\Entity\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class CreateUserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $encoder,
    ) {
    }

    public function handle(string $email, array $roles, string $password): string
    {

        $user = User::registerUser(
          new Email($email),
          $roles,
        );

        $encoded = $this->encoder->hashPassword($user, $password);
        $user->setPassword($encoded);

        $this->userRepository->save($user);

        return $this->serializer->serialize($user, 'json');
    }
}
