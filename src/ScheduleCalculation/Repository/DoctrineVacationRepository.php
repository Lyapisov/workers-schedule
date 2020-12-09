<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\Entity\Vacation;
use App\ScheduleCalculation\UseCase\Schedule\Get\VacationRepository;
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

    public function findByWorkerId(string $workerId): array
    {
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