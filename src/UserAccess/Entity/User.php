<?php

declare(strict_types=1);

namespace App\UserAccess\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Пользователь системы
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * Идентификатор
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id()
     *
     * @var string
     */
    private string $id;

    /**
     * Логин
     *
     * @ORM\Column(name="login", type="string", unique=true)
     *
     * @var string
     */
    private string $login;

    /**
     * Электронная почта
     *
     * @ORM\Column(name="email", type="string", unique=true)
     *
     * @var string
     */
    private string $email;

    /**
     * Пароль для входа
     *
     * @ORM\Column(name="password", type="string")
     *
     * @var string
     */
    private string $password;

    /**
     * Роль пользователя в системе
     *
     * @ORM\Column(name="role", type="string")
     *
     * @var string
     */
    private string $role;

    /**
     * Дата регистрации пользователя
     *
     * @ORM\Column(name="registration_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $registrationDate;

    /**
     * Годовой токен авторизации
     *
     * @ORM\Column(name="annual_auth_token", type="string")
     *
     * @var string
     */
    private string $annualAuthToken;

    /**
     * User constructor.
     * @param string $id
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $role
     * @param DateTimeImmutable $registrationDate
     * @param string $authToken
     */
    public function __construct(
        string $id,
        string $login,
        string $email,
        string $password,
        string $role,
        DateTimeImmutable $registrationDate,
        string $authToken
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->registrationDate = $registrationDate;
        $this->authToken = $authToken;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRegistrationDate(): DateTimeImmutable
    {
        return $this->registrationDate;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

}