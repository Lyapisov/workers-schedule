<?php

declare(strict_types=1);

namespace App\UserAccess\Service;

use App\UserAccess\UseCase\SignUp\TokenOperator as ITokenOperator;

final class TokenOperator implements ITokenOperator
{
    /**
     * @inheritDoc
     */
    public function generateAnnual(): string
    {
        // TODO: Implement generateAnnual() method.
    }

    /**
     * @inheritDoc
     */
    public function generateTemporary(): string
    {
        // TODO: Implement generateTemporary() method.
    }

    /**
     * @inheritDoc
     */
    public function checkAnnual(string $userId): bool
    {
        // TODO: Implement checkAnnual() method.
    }
}