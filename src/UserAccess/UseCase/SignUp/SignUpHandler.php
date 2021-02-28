<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

use App\UserAccess\UseCase\ReadModel\UserReadModel;
use App\UserAccess\UseCase\ReadModel\UserRepository;

final class SignUpHandler
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var PasswordOperator
     */
    private PasswordOperator $passwordOperator;
    /**
     * @var TokenOperator
     */
    private TokenOperator $tokenOperator;

    /**
     * @param UserRepository $userRepository
     * @param PasswordOperator $passwordOperator
     * @param TokenOperator $tokenOperator
     */
    public function __construct(
        UserRepository $userRepository,
        PasswordOperator $passwordOperator,
        TokenOperator $tokenOperator
    ) {
        $this->userRepository = $userRepository;
        $this->passwordOperator = $passwordOperator;
        $this->tokenOperator = $tokenOperator;
    }

    public function handle(SignUpCommand $command): UserReadModel
    {
        $login = $command->getLogin();
        $email = $command->getEmail();

        if ($this->userRepository->existsByLogin($login)) {
            throw new \DomainException('Пользователь с таким логином уже существует.');
        }

        if ($this->userRepository->existsByEmail($email)) {
            throw new \DomainException('Пользователь с такой почтой уже существует.');
        }

        $encryptedPassword = '';

        return new UserReadModel(
            'dd',
            'dd',
            'dd',
            'dd'
        );

    }
}