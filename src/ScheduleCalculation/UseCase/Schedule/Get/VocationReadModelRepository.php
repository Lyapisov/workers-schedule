<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;


interface VocationReadModelRepository
{
    /**
     * @param string $workerId
     * @return array
     */
    public function findByWorkerId(string $workerId): array;
}