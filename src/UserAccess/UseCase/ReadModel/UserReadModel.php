<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\ReadModel;

final class UserReadModel
{
    /**
     * @var string
     */
    private string $login;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $role;
    /**
     * @var string
     */
    private string $annualToken;
    /**
     * Временный токен авторизации. Генерируется если годовой токен действителен.
     *
     * @var string
     */
    private string $temporaryToken;

    /**
     * @param string $login
     * @param string $email
     * @param string $role
     * @param string $annualToken
     * @param string $temporaryToken
     */
    public function __construct(
        string $login,
        string $email,
        string $role,
        string $annualToken,
        string $temporaryToken
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->role = $role;
        $this->annualToken = $annualToken;
        $this->temporaryToken = $temporaryToken;
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
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getAnnualToken(): string
    {
        return $this->annualToken;
    }

    /**
     * @return string
     */
    public function getTemporaryToken(): string
    {
        return $this->temporaryToken;
    }

}