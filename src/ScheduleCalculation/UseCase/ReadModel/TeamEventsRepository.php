<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\ReadModel;


interface TeamEventsRepository
{
    /**
     * @return array
     */
    public function findAll(): array;
}