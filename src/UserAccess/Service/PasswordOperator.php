<?php

declare(strict_types=1);

namespace App\UserAccess\Service;

use App\UserAccess\UseCase\SignUp\PasswordOperator as IPasswordOperator;

final class PasswordOperator implements IPasswordOperator
{
    /**
     * @inheritDoc
     */
    public function encryptPassword(string $password): string
    {
        // TODO: Implement encryptPassword() method.
    }

    /**
     * @inheritDoc
     */
    public function checkPassword(string $enteredPassword, string $currentPassword): bool
    {
        // TODO: Implement checkPassword() method.
    }
}