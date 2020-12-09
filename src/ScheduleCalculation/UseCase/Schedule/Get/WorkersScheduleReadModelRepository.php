<?php


namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use Symfony\Component\Validator\Constraints\Date;

interface WorkersScheduleReadModelRepository
{
    /**
     * @param string $workerId
     * @return array
     */
    public function find(string $workerId): array;
}