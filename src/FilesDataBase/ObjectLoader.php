<?php

declare(strict_types=1);

namespace App\FilesDataBase\UserAccess;

use App\UserAccess\Entity\User;

class ObjectLoader
{
    private const USER_CLASS = 'User';

    /**
     * @param string $className
     * @param array $data
     * @return object|null
     */
    protected function loadObject(string $className, array $data): ?object
    {
        $object = null;
        if ($className === self::USER_CLASS) {
            $object = $this->loadUser($data);
        }

        return $object;
    }

    /**
     * @param array $data
     * @return object
     */
    private function loadUser(array $data): object
    {

        $user = new User(
            $data[0],
            $data[1],
            $data[2],
            $data[3],
            $data[4],
            $data[5],
            $data[6]
        );

        return $user;
    }
}
