<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\HolidaySchedule\Get;

use DateTimeImmutable;

final class HolidayScheduleReadModel
{
    /**
     * Дата дня
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * Начало свободного времени до работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBeforeWorking;

    /**
     * Конец свободного времени до работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBeforeWorking;

    /**
     * Начало обеденного перерыва
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBreak;

    /**
     * Конец обеденного перерыва
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBreak;

    /**
     * Начало свободного времени после работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startAfterWorking;

    /**
     * Конец свободного времени после работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endAfterWorking;

    /**
     * Начало полного выходного
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $fullHolidayStart;

    /**
     * Конец полного выходного
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $fullHolidayEnd;

    /**
     * Если полностью выходной день
     *
     * @var bool
     */
    private bool $isFullHoliday;

    private function __construct() {}

    public static function ifFullHoliday(
        DateTimeImmutable $date,
        DateTimeImmutable $fullHolidayStart,
        DateTimeImmutable $fullHolidayEnd
    ): HolidayScheduleReadModel {
        $holiday = new HolidayScheduleReadModel();
        $holiday->date = $date;
        $holiday->fullHolidayStart = $fullHolidayStart;
        $holiday->fullHolidayEnd = $fullHolidayEnd;
        $holiday->isFullHoliday = true;
        return $holiday;
    }

    public static function ifPartHoliday(
        DateTimeImmutable $date,
        DateTimeImmutable $startBeforeWorking,
        DateTimeImmutable $endBeforeWorking,
        DateTimeImmutable $startBreak,
        DateTimeImmutable $endBreak,
        DateTimeImmutable $startAfterWorking,
        DateTimeImmutable $endAfterWorking
    ): HolidayScheduleReadModel {
        $holiday = new HolidayScheduleReadModel();
        $holiday->date = $date;
        $holiday->startBeforeWorking = $startBeforeWorking;
        $holiday->endBeforeWorking = $endBeforeWorking;
        $holiday->startBreak = $startBreak;
        $holiday->endBreak = $endBreak;
        $holiday->startAfterWorking = $startAfterWorking;
        $holiday->endAfterWorking = $endAfterWorking;
        $holiday->isFullHoliday = false;
        return $holiday;
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
    public function getStartBeforeWorking(): DateTimeImmutable
    {
        return $this->startBeforeWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndBeforeWorking(): DateTimeImmutable
    {
        return $this->endBeforeWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartBreak(): DateTimeImmutable
    {
        return $this->startBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndBreak(): DateTimeImmutable
    {
        return $this->endBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartAfterWorking(): DateTimeImmutable
    {
        return $this->startAfterWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndAfterWorking(): DateTimeImmutable
    {
        return $this->endAfterWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFullHolidayStart(): DateTimeImmutable
    {
        return $this->fullHolidayStart;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFullHolidayEnd(): DateTimeImmutable
    {
        return $this->fullHolidayEnd;
    }

    /**
     * @return bool
     */
    public function isFullHoliday(): bool
    {
        return $this->isFullHoliday;
    }

}