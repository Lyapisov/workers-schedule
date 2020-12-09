<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use \App\ScheduleCalculation\UseCase\Schedule\Get\WorkersScheduleReadModelRepository;

class DoctrineWorkersScheduleReadRepository implements WorkersScheduleReadModelRepository
{

    /**
     * @param string $workerId
     * @return array
     */
    public function find(string $workerId): array
    {
        // TODO: Implement find() method.
    }
}