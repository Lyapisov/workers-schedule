<?php
declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\ReadModel;

use DateTimeImmutable;

final class EventDay
{
    /**
     * Дата дня мероприятия
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * Время начала мероприятия этого дня
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $start;

    /**
     * Время окончания мероприятия этого дня
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $end;

    /**
     * EventDay constructor.
     * @param DateTimeImmutable $date
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    public function __construct(
        DateTimeImmutable $date,
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) {
        $this->date = $date;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}