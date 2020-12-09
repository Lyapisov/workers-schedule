<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Time;

/**
 * Командные мероприятия
 *
 *@ORM\Entity
 * @ORM\Table(name="team-events")
 */
class TeamEvent
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
     * Дата начала мероприятия
     *
     * @ORM\Column(name="start_date", type="date")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startDate;

    /**
     * Дата окончания мероприятия
     *
     * @ORM\Column(name="end_date", type="date")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endDate;

    /**
     * Начало мероприятия
     *
     * @ORM\Column(name="start_time", type="time[(0)]")
     *
     * @var Time
     */
    private Time $startTime;

    /**
     * Окончание мероприятия
     *
     * @ORM\Column(name="end_time", type="time[(0)]")
     *
     * @var Time
     */
    private Time $endTime;

    /**
     * TeamEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $endDate
     * @param Time $startTime
     * @param Time $endTime
     */
    public function __construct(string $id, DateTimeImmutable $startDate, DateTimeImmutable $endDate, Time $startTime, Time $endTime)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }


}