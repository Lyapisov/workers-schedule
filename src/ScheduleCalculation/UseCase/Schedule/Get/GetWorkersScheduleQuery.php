<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use Symfony\Component\Validator\Constraints\Date;


final class GetWorkersScheduleQuery
{
    /**
     * @var string
     */
    private string $workerId;

    /**
     * @var Date
     */
    private Date $startDate;

    /**
     * @var Date
     */
    private Date $endDate;

    /**
     * GetWorkersScheduleQuery constructor.
     * @param string $workerId
     * @param Date $startDate
     * @param Date $endDate
     */
    public function __construct(string $workerId, Date $startDate, Date $endDate)
    {
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
     * @return Date
     */
    public function getStartDate(): Date
    {
        return $this->startDate;
    }

    /**
     * @return Date
     */
    public function getEndDate(): Date
    {
        return $this->endDate;
    }
}