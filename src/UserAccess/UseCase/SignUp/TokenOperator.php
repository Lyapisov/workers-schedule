<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

interface TokenOperator
{
    /**
     * @return string
     */
    public function generateAnnual(): string;

    /**
     * @return string
     */
    public function generateTemporary(): string;

    /**
     * @param string $userId
     * @return bool
     */
    public function checkAnnual(string $userId): bool;
}