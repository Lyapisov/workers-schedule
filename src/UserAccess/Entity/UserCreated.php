<?php

declare(strict_types=1);

namespace App\UserAccess\Entity;

final class UserCreated
{
    /**
     * @var string
     */
    private string $userId;

    /**
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
