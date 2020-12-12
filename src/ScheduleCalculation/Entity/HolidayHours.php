<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;

/**
 * Выходные часы
 */
final class HolidayHours
{
    /**
     * Начало выходного времени до работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBeforeWorking;

    /**
     * Конец выходного времени до работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBeforeWorking;

    /**
     * Начало выходного времени после работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startAfterWorking;

    /**
     * Конец выходного времени после работы
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endAfterWorking;

    /**
     * HolidayHours constructor.
     * @param DateTimeImmutable $startBeforeWorking
     * @param DateTimeImmutable $endBeforeWorking
     * @param DateTimeImmutable $startAfterWorking
     * @param DateTimeImmutable $endAfterWorking
     */
    public function __construct(
        DateTimeImmutable $startBeforeWorking,
        DateTimeImmutable $endBeforeWorking,
        DateTimeImmutable $startAfterWorking,
        DateTimeImmutable $endAfterWorking
    ) {
        $this->startBeforeWorking = $startBeforeWorking;
        $this->endBeforeWorking = $endBeforeWorking;
        $this->startAfterWorking = $startAfterWorking;
        $this->endAfterWorking = $endAfterWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartBeforeWorking(): DateTimeImmutable
    {
        return $this->startBeforeWorking;
    }

    /**
     * @param DateTimeImmutable $startBeforeWorking
     */
    public function setStartBeforeWorking(DateTimeImmutable $startBeforeWorking): void
    {
        $this->startBeforeWorking = $startBeforeWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndBeforeWorking(): DateTimeImmutable
    {
        return $this->endBeforeWorking;
    }

    /**
     * @param DateTimeImmutable $endBeforeWorking
     */
    public function setEndBeforeWorking(DateTimeImmutable $endBeforeWorking): void
    {
        $this->endBeforeWorking = $endBeforeWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartAfterWorking(): DateTimeImmutable
    {
        return $this->startAfterWorking;
    }

    /**
     * @param DateTimeImmutable $startAfterWorking
     */
    public function setStartAfterWorking(DateTimeImmutable $startAfterWorking): void
    {
        $this->startAfterWorking = $startAfterWorking;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndAfterWorking(): DateTimeImmutable
    {
        return $this->endAfterWorking;
    }

    /**
     * @param DateTimeImmutable $endAfterWorking
     */
    public function setEndAfterWorking(DateTimeImmutable $endAfterWorking): void
    {
        $this->endAfterWorking = $endAfterWorking;
    }
}