<?php

declare(strict_types=1);

namespace App\UserAccess\Repository;

use App\UserAccess\Entity\User;
use App\UserAccess\UseCase\ReadModel\UserRepository;
use App\FilesDataBase\OperatorSCV;
use Ramsey\Uuid\Uuid;

final class FileSystemUserRepository implements UserRepository
{
    const USERS_DATA_BASE = '\App\FilesDataBase\DataBase\UserAccess\Users\users.csv';

    private OperatorSCV $operatorSCV;

    /**
     * @param OperatorSCV $operatorSCV
     */
    public function __construct(OperatorSCV $operatorSCV)
    {
        $this->operatorSCV = $operatorSCV;
    }

    /**
     * @inheritDoc
     */
    public function existsByLogin(string $login): bool
    {
        $isDbFound = $this->operatorSCV->findDataBase(self::USERS_DATA_BASE);

        if (!$isDbFound) {
            $this->operatorSCV->createDataBase(self::USERS_DATA_BASE);
        }
        $isDbFound = $this->operatorSCV->findDataBase(self::USERS_DATA_BASE);
var_dump($isDbFound);
        $field = 'login';
        $value = $login;
        $user = $this->operatorSCV->findByValue($field, $value, self::USERS_DATA_BASE);

        return empty($user) ? false : true;
    }

    /**
     * @inheritDoc
     */
    public function existsByEmail(string $email): bool
    {
        $isDbFound = $this->operatorSCV->findDataBase(self::USERS_DATA_BASE);

        if (!$isDbFound) {
            $this->operatorSCV->createDataBase(self::USERS_DATA_BASE);
        }

        $field = 'email';
        $value = $email;
        $user = $this->operatorSCV->findByValue($field, $value, self::USERS_DATA_BASE);

        return empty($user) ? false : true;
    }

    /**
     * @return string
     */
    public function generateNewId(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $isDbFound = $this->operatorSCV->findDataBase(self::USERS_DATA_BASE);

        if (!$isDbFound) {
            $this->operatorSCV->createDataBase(self::USERS_DATA_BASE);
        }

        $this->operatorSCV->recordRow($user, self::USERS_DATA_BASE);
    }

}
