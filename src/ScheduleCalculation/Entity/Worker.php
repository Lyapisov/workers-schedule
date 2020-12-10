<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Работник
 *
 * @ORM\Entity
 * @ORM\Table(name="workers")
 */
class Worker
{
    /**
     * Идентификатор
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     *
     * @var string
     */
    private string $id;

    /**
     * Начало рабочего дня
     *
     * @ORM\Column(name="start_time", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startTime;

    /**
     * Конец рабочего дня
     *
     * @ORM\Column(name="end_time", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endTime;

    /**
     * Начало обеденного перерыва
     *
     * @ORM\Column(name="start_break", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startBreak;

    /**
     * Конец обеденного перерыва
     *
     * @ORM\Column(name="end_break", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endBreak;

    /**
     * Отпуска работника
     *
     * @ORM\Column(name="vocation", type="time")
     *
     * @var string[]
     */
    private array $vacation;

    /**
     * Worker constructor.
     * @param string $id
     * @param DateTimeImmutable $startTime
     * @param DateTimeImmutable $endTime
     * @param DateTimeImmutable $startBreak
     * @param DateTimeImmutable $endBreak
     * @param array|string[] $vacation
     */
    public function __construct(string $id, DateTimeImmutable $startTime, DateTimeImmutable $endTime, DateTimeImmutable $startBreak, DateTimeImmutable $endBreak, $vacation)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->startBreak = $startBreak;
        $this->endBreak = $endBreak;
        $this->vacation = $vacation;
    }


}