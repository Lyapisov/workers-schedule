<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;


use App\ScheduleCalculation\UseCase\Schedule\Get\VocationReadModelRepository;

class DoctrineVocationReadRepository implements VocationReadModelRepository
{
    public function findByWorkerId(string $workerId): array
    {
        // TODO: Implement findByWorkerId() method.
    }
}