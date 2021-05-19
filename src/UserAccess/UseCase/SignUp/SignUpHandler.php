<?php

declare(strict_types=1);

namespace App\UserAccess\UseCase\SignUp;

use App\UserAccess\Entity\Role;
use App\UserAccess\Entity\User;
use App\UserAccess\UseCase\ReadModel\UserReadModel;
use App\UserAccess\UseCase\ReadModel\UserRepository;
use DateTimeImmutable;

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
        $role = $command->getRole();

        if ($this->userRepository->existsByLogin($login)) {
            throw new \DomainException('Пользователь с таким логином уже существует.');
        }

        if ($this->userRepository->existsByEmail($email)) {
            throw new \DomainException('Пользователь с такой почтой уже существует.');
        }

        $encryptedPassword = '';
        if ($command->getPassword()) {
            $encryptedPassword = $this->passwordOperator->encryptPassword($command->getPassword());
        }

        $newId = $this->userRepository->generateNewId();
        $annualToken = $this->tokenOperator->generateAnnual();

        $user = new User(
            $newId,
            $login,
            $email,
            $encryptedPassword,
            Role::create($role),
            new DateTimeImmutable(),
            $annualToken
        );

        $this->userRepository->save($user);

        $temporaryToken = $this->tokenOperator->generateTemporary();

        return new UserReadModel(
            $user->getLogin(),
            $user->getEmail(),
            $user->getRole()->get(),
            $user->getAnnualToken(),
            $temporaryToken,
        );
    }
}
