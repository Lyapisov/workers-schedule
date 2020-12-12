<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\HolidaySchedule\Get;


interface VacationRepository
{
    /**
     * @param string $workerId
     * @return array
     */
    public function findByWorkerId(string $workerId): array;
}