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
     * Мероприятие
     *
     * @var TeamEvent|null
     */
    private ?TeamEvent $teamEvent;

    /**
     * CalendarDate constructor.
     * @param DateTimeImmutable $value
     * @param bool $isHoliday
     * @param TeamEvent|null $teamEvent
     */
    public function __construct(
        DateTimeImmutable $value,
        bool $isHoliday,
        ?TeamEvent $teamEvent = null
    ) {
        $this->value = $value;
        $this->isHoliday = $isHoliday;
        $this->teamEvent = $teamEvent;
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

    /**
     * @return TeamEvent|null
     */
    public function getTeamEvent(): ?TeamEvent
    {
        return $this->teamEvent;
    }




}