<?php

declare(strict_types=1);

namespace App\UserAccess\Repository;

use App\UserAccess\Entity\User;
use App\UserAccess\UseCase\ReadModel\UserRepository;
use App\FilesDataBase\OperatorSCV;
use Exception;
use Ramsey\Uuid\Uuid;

final class FileSystemUserRepository implements UserRepository
{
    private OperatorSCV $operatorSCV;
    private string $userDataBase;

    /**
     * @param OperatorSCV $operatorSCV
     */
    public function __construct(OperatorSCV $operatorSCV, string $userDataBase)
    {
        $this->operatorSCV = $operatorSCV;
        $this->userDataBase = $userDataBase;
    }

    /**
     * @param string $id
     * @return User|null
     * @throws Exception
     */
    public function findById(string $id): ?User
    {
        $isDbFound = $this->operatorSCV->findDataBase($this->userDataBase);

        if (!$isDbFound) {
            throw new Exception('База данных не найдена!');
        }

        $field = 'id';
        $value = $id;

        /** @var User $user */
        $user = $this->operatorSCV->findByValue($field, $value, $this->userDataBase);

        return $user;
    }

    public function existsByLogin(string $login): bool
    {
        $isDbFound = $this->operatorSCV->findDataBase($this->userDataBase);

        if (!$isDbFound) {
            throw new Exception('База данных не найдена!');
        }

        $field = 'login';
        $value = $login;
        $user = $this->operatorSCV->findByValue($field, $value, $this->userDataBase);

        return empty($user) ? false : true;
    }

    public function existsByEmail(string $email): bool
    {
        $isDbFound = $this->operatorSCV->findDataBase($this->userDataBase);

        if (!$isDbFound) {
            throw new Exception('База данных не найдена!');
        }

        $field = 'email';
        $value = $email;
        $user = $this->operatorSCV->findByValue($field, $value, $this->userDataBase);

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
        $isDbFound = $this->operatorSCV->findDataBase($this->userDataBase);

        if (!$isDbFound) {
            throw new Exception('База данных не найдена!');
        }

        $this->operatorSCV->recordRow($user, $this->userDataBase);
    }
}
