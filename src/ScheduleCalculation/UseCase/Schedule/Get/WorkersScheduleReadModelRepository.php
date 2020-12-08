<?php


namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use Symfony\Component\Validator\Constraints\Date;

interface WorkersScheduleReadModelRepository
{
    /**
     * @param string $workerId
     * @param Date $startDate
     * @param Date $endDate
     * @return array
     */
    public function find(string $workerId, Date $startDate, Date $endDate): array;
}