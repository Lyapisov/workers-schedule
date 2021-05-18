<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\ReadModel;

use App\UserAccess\Entity\User;

interface UserRepository
{
    /**
     * @param string $id
     * @return User|null
     */
    public function findById(string $id): ?User;

    /**
     * @param string $login
     * @return bool
     */
    public function existsByLogin(string $login): bool;

    /**
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool;

    /**
     * @return string
     */
    public function generateNewId(): string;

    /**
     * @param User $user
     */
    public function save(User $user): void;

}
