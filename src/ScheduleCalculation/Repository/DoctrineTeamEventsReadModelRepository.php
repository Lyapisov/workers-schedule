<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\UseCase\Schedule\Get\TeamEventsReadModelRepository;

final class DoctrineTeamEventsReadModelRepository implements TeamEventsReadModelRepository
{
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }
}