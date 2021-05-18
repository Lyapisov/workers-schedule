<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

final class SignUpCommand
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
    private string $password;
    /**
     * @var string
     */
    private string $role;

    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @param string $role
     */
    public function __construct(
        string $login,
        string $email,
        string $password,
        string $role
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
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

}