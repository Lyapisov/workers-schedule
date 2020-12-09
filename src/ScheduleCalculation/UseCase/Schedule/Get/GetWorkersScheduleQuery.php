<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use DateTimeImmutable;


final class GetWorkersScheduleQuery
{
    /**
     * @var string
     */
    private string $workerId;

    /**
     * @var string
     */
    private string $startDate;

    /**
     * @var string
     */
    private string $endDate;

    /**
     * GetWorkersScheduleQuery constructor.
     * @param string $workerId
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(
        string $workerId,
        string $startDate,
        string $endDate
    ) {
        $this->workerId = $workerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getWorkerId(): string
    {
        return $this->workerId;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }
}