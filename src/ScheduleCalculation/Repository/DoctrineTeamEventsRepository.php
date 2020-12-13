<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Repository;

use App\ScheduleCalculation\Entity\TeamEvent;
use App\ScheduleCalculation\UseCase\ReadModel\EventDay;
use App\ScheduleCalculation\UseCase\ReadModel\TeamEventsRepository;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
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

    /**
     * @return EventDay[]
     */
    public function findAll(): array
    {
        $eventsData = $this->getAllTeamEvent();

        $eventDays = [];
        foreach ($eventsData as $event) {

            $begin = DateTimeImmutable::createFromFormat('Y-m-d', $event["start"]
                ->format('Y-m-d'));
            $end = DateTimeImmutable::createFromFormat('Y-m-d', $event["end"]
                ->format('Y-m-d'))
                ->modify('+1 day');

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $amountDays = iterator_count($period);
            for ($i = 1; $i <= $amountDays; $i++) {

                $date = $period->getStartDate();
                $start = $event["start"];
                $end = $event["end"];

                if ($i != 1) {
                    $date = $date->modify('+' . $i-1 . ' day');
                    $start = DateTimeImmutable::createFromFormat('H:i:s', '00:00:00');
                }
                if ($amountDays > 1) {
                    $end = DateTimeImmutable::createFromFormat('H:i:s', '23:59:59');
                }
                if ($i == $amountDays) $end = $event["end"];

                $eventDays[] = new EventDay(
                    $date,
                    $start,
                    $end
                );
            }
        }
        return $eventDays;
    }

    private function getAllTeamEvent(): array {
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