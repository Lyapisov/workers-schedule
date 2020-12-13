<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\Entity\TeamEvent;
use App\ScheduleCalculation\UseCase\ReadModel\TeamEventsRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTeamEventsRepository implements TeamEventsRepository
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

    public function findAll(): array
    {
        $queryBuilder = $this
            ->em
            ->createQueryBuilder()
            ->select(
                'teamEvent.id',
                'teamEvent.start',
                'teamEvent.end'
                )
            ->from(TeamEvent::class, 'teamEvent');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}