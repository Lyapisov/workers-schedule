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
    private bool $isHoliday = false;

    /**
     * Если дата - отпускной день
     *
     * @var bool
     */
    private bool $isVacation = false;

    /**
     * Если на дату назначено мероприятие
     *
     * @var bool
     */
    private bool $isEvent = false;

    /**
     * Начало мероприятия
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $eventStartHour;

    /**
     * Конец мероприятия
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $eventEndHour;

    /**
     * Время начала работы до обеда
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $startWorkingTimeBeforeBreak;

    /**
     * Время окончания работы до обеда
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $endWorkingTimeBeforeBreak;

    /**
     * Время начала работы после обеда
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $startWorkingTimeAfterBreak;

    /**
     * Время окончания работы после обеда
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $endWorkingTimeAfterBreak;

}