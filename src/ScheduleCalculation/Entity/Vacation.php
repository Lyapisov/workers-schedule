<?php


namespace App\ScheduleCalculation\Entity;


use Symfony\Component\Validator\Constraints\Date;

/**
 * Отпуск
 *
 *@ORM\Entity
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

    /**
     * Vacation constructor.
     * @param string $id
     * @param string $workerId
     * @param Date $startDate
     * @param Date $endDate
     */
    public function __construct(string $id, string $workerId, Date $startDate, Date $endDate)
    {
        $this->id = $id;
        $this->workerId = $workerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

}