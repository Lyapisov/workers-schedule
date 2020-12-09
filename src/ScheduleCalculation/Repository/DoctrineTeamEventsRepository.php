<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\Entity\TeamEvent;
use App\ScheduleCalculation\UseCase\Schedule\Get\TeamEventReadModel;
use App\ScheduleCalculation\UseCase\Schedule\Get\TeamEventsRepository;
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
        $teamEventsData = $this->getAllEvents();
        return array_map(fn($eventData) => new TeamEventReadModel(
            $eventData['id'],
            $eventData['startDate'],
            $eventData['endDate'],
            $eventData['startTime'],
            $eventData['endTime']
        )
        ,$teamEventsData);

    }

    private function getAllEvents(): array {
        $queryBuilder = $this
            ->em
            ->createQueryBuilder()
            ->select(
                'teamEvent.id',
                'teamEvent.startDate',
                'teamEvent.endDate',
                'teamEvent.startTime',
                'teamEvent.endTime',
            )
            ->from(TeamEvent::class, 'teamEvent');

        return $queryBuilder
            ->getQuery()
            ->getArrayResult();
    }
}