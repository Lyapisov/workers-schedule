<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Service\CalendarDates;

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

    /**
     * @return DateTimeImmutable
     */
    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isHoliday(): bool
    {
        return $this->isHoliday;
    }

}