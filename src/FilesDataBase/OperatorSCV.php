<?php

declare(strict_types=1);

namespace App\FilesDataBase;

use App\UserAccess\Entity\User;
use App\FilesDataBase\UserAccess\ObjectLoader;

final class OperatorSCV extends ObjectLoader
{
    private const GET_PREFIX = 'get';

    private string $filePath;

    /**
     * @param string $db
     * @return bool
     */
    public function findDataBase(string $db): bool
    {
        return file_exists($db);
    }

    /**
     * @param string $db
     */
    public function createDataBase(string $db): void
    {
        file_put_contents($db, 's');
var_dump('pos');
        if (!file_exists($db)) {
            throw new \DomainException('Ошибка при создании базы данных users.csv');
        }
    }

    /**
     * @param object $newRow
     * @param $db
     */
    public function recordRow(object $newRow, $db): void
    {
        $this->checkModel($newRow);

        $class = get_class($newRow);
        $methods = get_class_methods($class);

        $handle = fopen($db, "a");

        foreach ($methods as $method) {
            if (!strpos($method, self::GET_PREFIX)) {
                continue;
            }

            $value = $class->$method;
            fputcsv($handle, explode(";", $value), ";");
        }

        fclose($handle);
    }

    /**
     * @param string $field
     * @param $value
     * @param string $db
     * @return object|null
     */
    public function findByValue(string $field, $value, string $db): ?object
    {
       $allRows = $this->getAllRows($db);
       $className = $this->getClass($db);

       $objects = [];
       foreach ($allRows as $row) {
           $object = $this->loadObject($className, $row);
           $objects[] = $object;
       }

       $getter = self::GET_PREFIX . ucfirst($field);

       $searchObject = null;
       foreach ($objects as $object) {
           $searchValue = $object->$getter();
           if ($searchValue === $value) {
               $searchObject = $object;
               break;
           }
       }

       return $searchObject;
    }

    /**
     * @param object $model
     */
    private function checkModel(object $model): void
    {
        $class = get_class($model);
        if ($class){
            throw new \DomainException('Запиываемая модель не найдена');
        }

        $methods = get_class_methods($class);
        if (empty($methods)){
            throw new \DomainException('У модели отсутствуют методы для получения данных');
        }
    }

    /**
     * @param string $db
     * @return array
     */
    private function getAllRows(string $db): array
    {
        $handle = fopen($db, "r");

        $allRows = [];
        while (($row = fgetcsv($handle, 0, ";")) !== false) {
            $allRows[] = $row;
        }
        fclose($handle);

        return $allRows;
    }

    /**
     * @param string $db
     * @return string|null
     */
    private function getClass(string $db): ?string
    {
        $dbName = substr(end(explode('/', $db)), -5);

        if ($dbName === 'users') {
            return 'User';
        }

        return null;
    }

}
