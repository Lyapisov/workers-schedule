<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\Entity\Vacation;
use App\ScheduleCalculation\UseCase\ReadModel\VacationDay;
use App\ScheduleCalculation\UseCase\ReadModel\VacationRepository;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineVacationRepository implements VacationRepository
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * DoctrineTeamEventsReadModelRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $workerId
     * @return VacationDay[]
     * @throws \Exception
     */
    public function findByWorkerId(string $workerId): array
    {

        $vacationData = $this->getVacationByWorker($workerId);

        $vacationDays = [];
        foreach ($vacationData as $vacation){

            $begin = new DateTimeImmutable($vacation["startDate"]->format("Y-m-d"));
            $end = new DateTimeImmutable($vacation["endDate"]->format("Y-m-d"));
            $end = $end->modify('+1 day');

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $date) {
                $vacationDays[] = new VacationDay($date);
            }
        }
        return $vacationDays;

    }

    /**
     * @param string $workerId
     * @return array
     */
    private function getVacationByWorker(string $workerId): array {
        $queryBuilder = $this
            ->em
            ->createQueryBuilder()
            ->select(
                'vacation.id',
                'vacation.workerId',
                'vacation.startDate',
                'vacation.endDate',
                )
            ->from(Vacation::class, 'vacation')
            ->where('vacation.workerId = :workerId')
            ->setParameter(':workerId', $workerId);

        return $queryBuilder
            ->getQuery()
            ->getArrayResult();
    }
}