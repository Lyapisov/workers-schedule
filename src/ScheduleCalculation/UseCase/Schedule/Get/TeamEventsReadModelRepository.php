<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;


interface TeamEventsReadModelRepository
{

    /**
     * @return array
     */
    public function findAll(): array;
}