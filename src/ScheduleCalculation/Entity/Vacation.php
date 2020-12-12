<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Отпуск
 *
 * @ORM\Entity
 * @ORM\Table(name="vacations")
 */
class Vacation
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
     * Идентификатор работника
     *
     * @ORM\Column(name="workerId", type="string")
     *
     * @var string
     */
    private string $workerId;

    /**
     * Дата начала отпуска
     *
     * @ORM\Column(name="start_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startDate;

    /**
     * Дата окончания отпуска
     *
     * @ORM\Column(name="end_date", type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $endDate;

    /**
     * Vacation constructor.
     * @param string $id
     * @param string $workerId
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $endDate
     */
    public function __construct(
        string $id,
        string $workerId,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ) {
        $this->id = $id;
        $this->workerId = $workerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getWorkerId(): string
    {
        return $this->workerId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }
}