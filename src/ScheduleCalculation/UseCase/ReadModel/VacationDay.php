<?php
declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\ReadModel;

use DateTimeImmutable;

final class VacationDay
{
    /**
     * Дата отпускного дня
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * VacationDay constructor.
     * @param DateTimeImmutable|null $date
     */
    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

}