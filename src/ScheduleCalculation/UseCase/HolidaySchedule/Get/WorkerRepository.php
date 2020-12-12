<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\HolidaySchedule\Get;

interface WorkerRepository
{
    /**
     * @param string $workerId
     * @return array
     */
    public function find(string $workerId): array;
}