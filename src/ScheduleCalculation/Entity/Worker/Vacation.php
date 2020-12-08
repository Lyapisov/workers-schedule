<?php


namespace App\ScheduleCalculation\Entity\Worker;


use Symfony\Component\Validator\Constraints\Date;

/**
 * Отпуск
 *
 *@ORM\Entity
 * @ORM\Table(name="vacation")
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
     * @ORM\Column(name="start_date", type="date")
     *
     * @var Date
     */
    private Date $startDate;

    /**
     * Дата окончания отпуска
     *
     * @ORM\Column(name="end_date", type="date")
     *
     * @var Date
     */
    private Date $endDate;
}