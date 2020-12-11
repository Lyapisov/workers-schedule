<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;


use App\ScheduleCalculation\Entity\Breakfast;
use App\ScheduleCalculation\Entity\Worker;
use App\ScheduleCalculation\Entity\WorkingDay;
use App\ScheduleCalculation\Entity\WorkingHours;
use App\ScheduleCalculation\UseCase\Schedule\Get\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineWorkerRepository implements WorkerRepository
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
     * @return array
     */
    public function find(string $workerId): array
    {
        return $this->getBaseWorkerSchedule($workerId);

//        return array_map(fn($workerData) => new WorkingDay(
//            new WorkingHours(
//                $workerData['startTime'],
//                $workerData['startBreak'],
//                $workerData['endBreak'],
//                $workerData['endTime'],
//            ),
//            new Breakfast(
//                $workerData['startBreak'],
//                $workerData['endBreak'],
//            )
//        ), $workerData);
    }

    private function getBaseWorkerSchedule(string $workerId): array {
        $queryBuilder = $this
            ->em
            ->createQueryBuilder()
            ->select(
                'worker.id',
                'worker.startTime',
                'worker.endTime',
                'worker.startBreak',
                'worker.endBreak',
                )
            ->from(Worker::class, 'worker')
            ->where('worker.id = :workerId')
            ->setParameter(':workerId', $workerId);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}