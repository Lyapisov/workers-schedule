<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;

/**
 * Выходной день
 */
final class HolidayDay
{
    /**
     * Дата выходного дня
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * Выходные часы
     *
     * @var HolidayHours
     */
    private HolidayHours $holidayHours;

    /**
     * Обед
     *
     * @var Breakfast
     */
    private Breakfast $breakfast;

    /**
     * Если в выходном дне есть рабочее время
     *
     * @var bool
     */
    private bool $isFullHoliday;

    private function __construct(){}

    public static function ifFullDayHoliday(
        DateTimeImmutable $date,
        bool $isFullHoliday
    ): HolidayDay {
        $holidayDay = new HolidayDay();
        $holidayDay->date = $date;
        $holidayDay->isFullHoliday = $isFullHoliday;
        return $holidayDay;
    }

    public static function ifPartDayHoliday(
        DateTimeImmutable $date,
        HolidayHours $holidayHours,
        Breakfast $breakfast,
        bool $isFullHoliday
    ): HolidayDay {

        $holidayDay = new HolidayDay();
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