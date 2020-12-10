<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Командные мероприятия
 *
 * @ORM\Entity
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
     * @ORM\Column(name="start_time", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startTime;

    /**
     * Окончание мероприятия
     *
     * @ORM\Column(name="end_time", type="time")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endTime;

    /**
     * TeamEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $endDate
     * @param DateTimeImmutable $startTime
     * @param DateTimeImmutable $endTime
     */
    public function __construct(string $id, DateTimeImmutable $startDate, DateTimeImmutable $endDate, DateTimeImmutable $startTime, DateTimeImmutable $endTime)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }


}