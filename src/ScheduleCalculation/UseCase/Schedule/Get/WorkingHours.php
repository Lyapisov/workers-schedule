<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use DateTimeImmutable;

/**
 * Рабочие часы
 */
final class WorkingHours
{
    /**
     * Начало рабочего дня до обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBeforeBreak;

    /**
     * Конец рабочего дня до обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBeforeBreak;

    /**
     * Начало рабочего дня после обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startAfterBreak;

    /**
     * Конец рабочего дня после обеда
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endAfterBreak;

    /**
     * WorkingHours constructor.
     * @param DateTimeImmutable $startBeforeBreak
     * @param DateTimeImmutable $endBeforeBreak
     * @param DateTimeImmutable $startAfterBreak
     * @param DateTimeImmutable $endAfterBreak
     */
    public function __construct(
        DateTimeImmutable $startBeforeBreak,
        DateTimeImmutable $endBeforeBreak,
        DateTimeImmutable $startAfterBreak,
        DateTimeImmutable $endAfterBreak
    ) {
        $this->startBeforeBreak = $startBeforeBreak;
        $this->endBeforeBreak = $endBeforeBreak;
        $this->startAfterBreak = $startAfterBreak;
        $this->endAfterBreak = $endAfterBreak;
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

    /**
     * @param DateTimeImmutable $startBeforeBreak
     */
    public function setStartBeforeBreak(DateTimeImmutable $startBeforeBreak): void
    {
        $this->startBeforeBreak = $startBeforeBreak;
    }

    /**
     * @param DateTimeImmutable $endBeforeBreak
     */
    public function setEndBeforeBreak(DateTimeImmutable $endBeforeBreak): void
    {
        $this->endBeforeBreak = $endBeforeBreak;
    }

    /**
     * @param DateTimeImmutable $startAfterBreak
     */
    public function setStartAfterBreak(DateTimeImmutable $startAfterBreak): void
    {
        $this->startAfterBreak = $startAfterBreak;
    }

    /**
     * @param DateTimeImmutable $endAfterBreak
     */
    public function setEndAfterBreak(DateTimeImmutable $endAfterBreak): void
    {
        $this->endAfterBreak = $endAfterBreak;
    }

}