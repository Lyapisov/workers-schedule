<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;


use App\ScheduleCalculation\Entity\Worker;
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
        $queryBuilder = $this
            ->em
            ->createQueryBuilder()
            ->select(
                'worker.id',
                'worker.startDate',
                'worker.endDate',
                'worker.startTime',
                'worker.endTime',
                )
            ->from(Worker::class, 'worker')
            ->where('worker.id = :workerId')
            ->setParameter(':workerId', $workerId);

        return $queryBuilder
            ->getQuery()
            ->getArrayResult();
    }
}