<?php


namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use Symfony\Component\Validator\Constraints\Date;

interface WorkerRepository
{
    /**
     * @param string $workerId
     * @return array
     */
    public function find(string $workerId): array;
}