<?php

declare(strict_types=1);

namespace App\UserAccess\Service;

use App\UserAccess\UseCase\SignUp\TokenOperator as ITokenOperator;
use Ramsey\Uuid\Uuid;

final class TokenOperator implements ITokenOperator
{
    /**
     * @inheritDoc
     */
    public function generateAnnual(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @inheritDoc
     */
    public function generateTemporary(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @inheritDoc
     */
    public function checkAnnual(string $userId): bool
    {
        // TODO: Implement checkAnnual() method.
    }
}