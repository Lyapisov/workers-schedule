<?php

declare(strict_types=1);

namespace App\UserAccess\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Роль пользователя системы
 *
 * @ORM\Embeddable()
 */
class Role
{
    private const FAN = 'fan';
    private const MUSICIAN = 'musician';
    private const PRODUCER = 'producer';

    /**
     * @ORM\Column(type="string", nullable=false, name="role")
     *
     * @var string
     */
    private string $role;

    private function __construct() {}

    public static function create(string $value): Role
    {
        $role = new Role();
        $role->role = $value;

        if (!($role->isFan() || $role->isMusician() || $role->isProducer())) {
            throw new \DomainException("Роль не может принимать значение \"{$value}\"");
        }

        return $role;
    }

    public static function fan(): Role
    {
        $role = new Role();
        $role->role = self::FAN;

        return $role;
    }

    public static function musician(): Role
    {
        $role = new Role();
        $role->role = self::MUSICIAN;

        return $role;
    }

    public static function producer(): Role
    {
        $role = new Role();
        $role->role = self::PRODUCER;

        return $role;
    }

    public function get(): string
    {
        return $this->role;
    }

    public function isFan(): bool
    {
        return $this->role === self::FAN;
    }

    public function isMusician(): bool
    {
        return $this->role === self::MUSICIAN;
    }

    public function isProducer(): bool
    {
        return $this->role === self::PRODUCER;
    }
}
