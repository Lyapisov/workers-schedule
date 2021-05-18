<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\HolidaySchedule\Get;

use App\ScheduleCalculation\UseCase\HolidaySchedule\Get\HolidayHours;
use App\ScheduleCalculation\UseCase\ReadModel\Breakfast;
use DateTimeImmutable;

/**
 * Выходной период дня
 */
final class HolidayPeriod
{
    /**
     * Дата выходного периода
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * Часы периода
     *
     * @var HolidayHours
     */
    private HolidayHours $holidayHours;

    /**
     * Период обеда
     *
     * @var Breakfast
     */
    private Breakfast $breakfast;

    /**
     * Если выходной период весь день
     *
     * @var bool
     */
    private bool $isFullHoliday;

    private function __construct(){}

    public static function ifFullHoliday(
        DateTimeImmutable $date,
        bool $isFullHoliday
    ): HolidayPeriod {
        $holidayDay = new HolidayPeriod();
        $holidayDay->date = $date;
        $holidayDay->isFullHoliday = $isFullHoliday;
        return $holidayDay;
    }

    public static function ifPartHoliday(
        DateTimeImmutable $date,
        HolidayHours $holidayHours,
        Breakfast $breakfast,
        bool $isFullHoliday
    ): HolidayPeriod {

        $holidayDay = new HolidayPeriod();
        $holidayDay->date = $date;
        $holidayDay->holidayHours = $holidayHours;
        $holidayDay->breakfast = $breakfast;
        $holidayDay->isFullHoliday = $isFullHoliday;
        return $holidayDay;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return HolidayHours
     */
    public function getHolidayHours(): HolidayHours
    {
        return $this->holidayHours;
    }

    /**
     * @return Breakfast
     */
    public function getBreakfast(): Breakfast
    {
        return $this->breakfast;
    }

    /**
     * @return bool
     */
    public function isFullHoliday(): bool
    {
        return $this->isFullHoliday;
    }

    /**
     * @param HolidayHours $holidayHours
     */
    public function setHolidayHours(HolidayHours $holidayHours): void
    {
        $this->holidayHours = $holidayHours;
    }

    /**
     * @param Breakfast $breakfast
     */
    public function setBreakfast(Breakfast $breakfast): void
    {
        $this->breakfast = $breakfast;
    }

    /**
     * @param bool $isFullHoliday
     */
    public function setIsFullHoliday(bool $isFullHoliday): void
    {
        $this->isFullHoliday = $isFullHoliday;
    }
}