<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;

/**
 * Класс отдельной календарной даты
 */
final class CalendarDate
{
    /**
     * Значение даты
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $value;

    /**
     * Если дата - выходной
     *
     * @var bool
     */
    private bool $isHoliday;

    /**
     * CalendarDate constructor.
     * @param DateTimeImmutable $value
     * @param bool $isHoliday
     */
    public function __construct(
        DateTimeImmutable $value,
        bool $isHoliday
    ) {
        $this->value = $value;
        $this->isHoliday = $isHoliday;
    }
}