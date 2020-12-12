<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use DateTimeImmutable;

/**
 * Модель для чтения рабочего графика
 */
final class ScheduleReadModel
{
    /**
     * Номер рабочего дня по календарю
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $day;

    /**
     * Старт рабочего времени до обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBeforeBreak;

    /**
     * Конец рабочего времени до обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBeforeBreak;

    /**
     * Старт рабочего времени после обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startAfterBreak;

    /**
     * Конец рабочего времени после обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endAfterBreak;

    /**
     * ScheduleReadModel constructor.
     * @param DateTimeImmutable $day
     * @param DateTimeImmutable $startBeforeBreak
     * @param DateTimeImmutable $endBeforeBreak
     * @param DateTimeImmutable $startAfterBreak
     * @param DateTimeImmutable $endAfterBreak
     */
    public function __construct(
        DateTimeImmutable $day,
        DateTimeImmutable $startBeforeBreak,
        DateTimeImmutable $endBeforeBreak,
        DateTimeImmutable $startAfterBreak,
        DateTimeImmutable $endAfterBreak
    ) {
        $this->day = $day;
        $this->startBeforeBreak = $startBeforeBreak;
        $this->endBeforeBreak = $endBeforeBreak;
        $this->startAfterBreak = $startAfterBreak;
        $this->endAfterBreak = $endAfterBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDay(): DateTimeImmutable
    {
        return $this->day;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartBeforeBreak(): DateTimeImmutable
    {
        return $this->startBeforeBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndBeforeBreak(): DateTimeImmutable
    {
        return $this->endBeforeBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartAfterBreak(): DateTimeImmutable
    {
        return $this->startAfterBreak;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndAfterBreak(): DateTimeImmutable
    {
        return $this->endAfterBreak;
    }

}