<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity\Worker;

use Symfony\Component\Validator\Constraints\Time;

/**
 * Работник
 *
 * @ORM\Entity
 * @ORM\Table(name="worker")
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
     * @ORM\Column(name="start_time", type="time[(0)]")
     *
     * @var Time
     */
    private Time $startTime;

    /**
     * Конец рабочего дня
     *
     * @ORM\Column(name="end_time", type="time[(0)]")
     *
     * @var Time
     */
    private Time $endTime;

    /**
     * Начало обеденного перерыва
     *
     * @ORM\Column(name="start_break", type="time[(0)]")
     *
     * @var Time
     */
    private Time $startBreak;

    /**
     * Конец обеденного перерыва
     *
     * @ORM\Column(name="end_break", type="time[(0)]")
     *
     * @var Time
     */
    private Time $endBreak;

    /**
     * Отпуска работника
     *
     * @ORM\Column(name="vocation", type="time[(0)]")
     *
     * @var string[]
     */
    private array $vacation;

}