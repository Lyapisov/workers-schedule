<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use Symfony\Component\Validator\Constraints\Time;

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

    /**
     * Worker constructor.
     * @param string $id
     * @param Time $startTime
     * @param Time $endTime
     * @param Time $startBreak
     * @param Time $endBreak
     * @param array|string[] $vacation
     */
    public function __construct(string $id, Time $startTime, Time $endTime, Time $startBreak, Time $endBreak, $vacation)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->startBreak = $startBreak;
        $this->endBreak = $endBreak;
        $this->vacation = $vacation;
    }


}