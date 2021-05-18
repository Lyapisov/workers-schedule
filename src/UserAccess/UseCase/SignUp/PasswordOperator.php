<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

interface PasswordOperator
{
    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword(string $password): string;

    /**
     * @param string $enteredPassword
     * @param string $currentPassword
     * @return bool
     */
    public function checkPassword(string $enteredPassword, string $currentPassword): bool;
}