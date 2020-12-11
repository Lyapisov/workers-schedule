<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use App\ScheduleCalculation\Entity\Breakfast;
use App\ScheduleCalculation\Entity\CalendarDate;
use App\ScheduleCalculation\Entity\EventDay;
use App\ScheduleCalculation\Entity\VacationDay;
use App\ScheduleCalculation\Entity\WorkingDay;
use App\ScheduleCalculation\Entity\WorkingHours;
use App\ScheduleCalculation\Service\DaysWithStatusService;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;

/**
 * Обработчик сценария получения графика работы
 */
final class GetWorkersScheduleHandler
{
    /**
     * @var WorkerRepository
     */
    private WorkerRepository $workerRepository;

    /**
     * @var VacationRepository
     */
    private VacationRepository $vocationRepository;

    /**
     * @var TeamEventsRepository
     */
    private TeamEventsRepository $teamEventsRepository;

    /**
     * @var DaysWithStatusService
     */
    private DaysWithStatusService $daysService;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkerRepository $workerRepository
     * @param VacationRepository $vocationRepository
     * @param TeamEventsRepository $teamEventsRepository
     * @param DaysWithStatusService $daysService
     */
    public function __construct(
        WorkerRepository $workerRepository,
        VacationRepository $vocationRepository,
        TeamEventsRepository $teamEventsRepository,
        DaysWithStatusService $daysService
    ) {
        $this->workerRepository = $workerRepository;
        $this->vocationRepository = $vocationRepository;
        $this->teamEventsRepository = $teamEventsRepository;
        $this->daysService = $daysService;
    }

    public function handle(GetWorkersScheduleQuery $query):array {

        $calendarDates = $this->getCalendarDates(
            $query->getStartDate(),
            $query->getEndDate()
        );

        $vacationDays = $this->getVacationDays($query->getWorkerId());

        $workingDays = $this->getWorkingDays($query->getWorkerId(), $calendarDates, $vacationDays);

        $eventDays = $this->getEventDays();

        $this->correctWorkingDays($workingDays, $eventDays);

        $readModel = [];

        foreach ($workingDays as $day) {
            $readModel[] = new ScheduleReadModel(
                $day->getDate(),
                $day->getWorkingHours()->getStartBeforeBreak(),
                $day->getWorkingHours()->getEndBeforeBreak(),
                $day->getWorkingHours()->getStartAfterBreak(),
                $day->getWorkingHours()->getEndAfterBreak(),
            );
        }

        return $readModel;

//            array_map(fn($workingDay) => new ScheduleReadModel(
//
//            $workingDay->getDate(),
//            $workingDay->getWorkingHours()->getStartBeforeBreak(),
//            $workingDay->getWorkingHours()->getEndBeforeBreak(),
//            $workingDay->getWorkingHours()->getStartAfterBreak(),
//            $workingDay->getWorkingHours()->getEndAfterBreak(),
//
//            ), $workingDays);




//        echo "<pre>";
//        var_dump($workingDays);
//        echo "</pre>";

    }

    private function getCalendarDates(string $startDate, string $endDate): array {
        $daysWithStatus = $this->daysService
            ->getForPeriod($startDate, $endDate);

        $calendarDate = [];
        foreach ($daysWithStatus as $day => $isHoliday) {
            $calendarDate[] = new CalendarDate(
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $day . ' 00:00:00'),
                (bool)$isHoliday
            );


        }
        return $calendarDate;
    }

    private function getVacationDays(string $workerId): array {
        $vacationData = $this->vocationRepository
            ->findByWorkerId($workerId);

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

    private function getWorkingDays(string $workerId, array $calendarDates, array $vacationDays): array {

        $workerData = $this->workerRepository->find($workerId);

        $workingDays = [];
        foreach ($calendarDates as $date) {
            $countVacationDay = 0;
            foreach ($vacationDays as $vacationDay) {

                if ($date->isHoliday()) break 1;
                if ($date->getValue() == $vacationDay->getDate()) break 1;
                $countVacationDay++;
                if($countVacationDay != count($vacationDays)) continue;

                $workingDays[] = new WorkingDay(
                    $date->getValue(),
                    new WorkingHours(
                        $workerData[0]['startTime'],
                        $workerData[0]['startBreak'],
                        $workerData[0]['endBreak'],
                        $workerData[0]['endTime'],
                    ),
                    new Breakfast(
                        $workerData[0]['startBreak'],
                        $workerData[0]['endBreak'],
                    )
                );

            }
        }
        return $workingDays;
    }

    private function getEventDays(): array {

        $teamEvents = $this->teamEventsRepository->findAll();

        $eventDays = [];
        foreach ($teamEvents as $event) {

            $a = DateTimeImmutable::createFromFormat('Y-m-d', $event["start"]->format('Y-m-d'));
            $b = DateTimeImmutable::createFromFormat('Y-m-d', $event["end"]->format('Y-m-d'));

            $begin = $a;
            $end = $b->modify('+1 day');

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
                if ($i == $amountDays) {
                    $end = $event["end"];
                }

                $eventDays[] = new EventDay(
                    $date,
                    $start,
                    $end
                );
            }
        }
        return $eventDays;
    }

    private function correctWorkingDays(array $workingDays, array $eventDays): void {
        foreach ($workingDays as $workDay) {
            foreach ($eventDays as $eventDay){

                $workDayWithoutHours = new DateTimeImmutable($workDay->getDate()->format('Y-m-d'));
                $eventDayWithoutHours = new DateTimeImmutable($eventDay->getDate()->format('Y-m-d'));

                $startEventDay = new DateTimeImmutable($eventDay->getStart()->format('H:i:s'));
                $endEventDay = new DateTimeImmutable($eventDay->getEnd()->format('H:i:s'));
                $startBeforeBreak = new DateTimeImmutable($workDay->getWorkingHours()->getStartBeforeBreak()->format('H:i:s'));
                $endBeforeBreak = new DateTimeImmutable($workDay->getWorkingHours()->getEndBeforeBreak()->format('H:i:s'));
                $startAfterBreak = new DateTimeImmutable($workDay->getWorkingHours()->getStartAfterBreak()->format('H:i:s'));
                $endAfterBreak = new DateTimeImmutable($workDay->getWorkingHours()->getEndAfterBreak()->format('H:i:s'));
                $ifDayNoPlanClose = new DateTimeImmutable('00:00:00');

                if ($workDayWithoutHours == $eventDayWithoutHours) {
                    if ($startEventDay > $startBeforeBreak && $startEventDay < $endBeforeBreak) {
                        $workDay->getWorkingHours()->setEndBeforeBreak($startEventDay);
                        $workDay->getWorkingHours()->setStartAfterBreak($ifDayNoPlanClose);
                        $workDay->getWorkingHours()->setEndAfterBreak($ifDayNoPlanClose);
                    }
                    if ($startEventDay > $startAfterBreak && $startEventDay < $endAfterBreak) {
                        $workDay->getWorkingHours()->setEndAfterBreak($startEventDay);
                    }

                    if ( $endEventDay > $startBeforeBreak  && $endEventDay < $endBeforeBreak) {
                        $workDay->getWorkingHours()->setStartBeforeBreak($endEventDay);
                    }

                    if ($endEventDay < $startBeforeBreak && $endEventDay > $endAfterBreak) {
                        $workDay->getWorkingHours()->setStartBeforeBreak($ifDayNoPlanClose);
                        $workDay->getWorkingHours()->setEndBeforeBreak($ifDayNoPlanClose);
                        $workDay->getWorkingHours()->setStartAfterBreak($ifDayNoPlanClose);
                        $workDay->getWorkingHours()->setEndAfterBreak($ifDayNoPlanClose);
                    }
                }
            }
        }
    }

}