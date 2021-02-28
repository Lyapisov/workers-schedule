<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\ReadModel;

interface UserRepository
{
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
}