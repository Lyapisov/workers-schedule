<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Командные мероприятия
 *
 * @ORM\Entity
 * @ORM\Table(name="team_events")
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
     * Дата и время начала мероприятия
     *
     * @ORM\Column(name="start_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $start;

    /**
     * Дата и время окончания мероприятия
     *
     * @ORM\Column(name="end_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $end;

    /**
     * TeamEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    public function __construct(
        string $id,
        DateTimeImmutable $start,
        DateTimeImmutable $end
    ) {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}