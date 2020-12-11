<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;

/**
 * Обеденный перерыв
 */
final class Breakfast
{
    /**
     * Начало перерыва
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $start;

    /**
     * Конец перерыва
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $end;

    /**
     * Breakfast constructor.
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    public function __construct(
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) {
        $this->start = $start;
        $this->end = $end;
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