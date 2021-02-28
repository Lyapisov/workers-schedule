<?php

declare(strict_types=1);

namespace App\UserAccess\Repository;

use App\UserAccess\UseCase\ReadModel\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

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

}