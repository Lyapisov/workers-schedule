<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use App\ScheduleCalculation\UseCase\Schedule\Get\WorkingHours;
use App\ScheduleCalculation\UseCase\ReadModel\Breakfast;
use DateTimeImmutable;

/**
 * Рабочий день
 */
final class WorkingDay
{
    /**
     * Дата рабочего дня
     *
     * @var DateTimeImmutable
     */
    private ?DateTimeImmutable $date;

    /**
     * Рабочие часы
     *
     * @var WorkingHours
     */
    private WorkingHours $workingHours;

    /**
     * Обед
     *
     * @var Breakfast
     */
    private Breakfast $breakfast;

    /**
     * WorkingDay constructor.
     * @param DateTimeImmutable|null $date
     * @param WorkingHours $workingHours
     * @param Breakfast $breakfast
     */
    public function __construct(
        ?DateTimeImmutable $date,
        WorkingHours $workingHours,
        Breakfast $breakfast
    ) {
        $this->date = $date;
        $this->workingHours = $workingHours;
        $this->breakfast = $breakfast;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return WorkingHours
     */
    public function getWorkingHours(): WorkingHours
    {
        return $this->workingHours;
    }

    /**
     * @return Breakfast
     */
    public function getBreakfast(): Breakfast
    {
        return $this->breakfast;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }



}