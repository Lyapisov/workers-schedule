<?php

declare(strict_types=1);

namespace App\UserAccess\Repository;

use App\UserAccess\Entity\User;
use App\UserAccess\UseCase\ReadModel\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class DoctrineUserRepository implements UserRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $login
     * @return bool
     */
    public function existsByLogin(string $login): bool
    {
        return $this->findByLogin($login);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        return $this->findByEmail($email);
    }

    /**
     * @return string
     */
    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}