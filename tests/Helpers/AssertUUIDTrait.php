<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

/**
 * Трейт для проверки значение на формат uuid.
 */
trait AssertUUIDTrait
{
    public $uuid = '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/';

    /**
     * @param string $value
     */
    private function assertUuid(string $value): void
    {
        preg_match($this->uuid, $value);
    }
}
