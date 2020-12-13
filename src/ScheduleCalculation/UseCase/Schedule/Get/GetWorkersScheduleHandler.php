<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use App\ScheduleCalculation\UseCase\ReadModel\Breakfast;
use App\ScheduleCalculation\Service\CalendarDates\CalendarDate;
use App\ScheduleCalculation\UseCase\ReadModel\EventDay;
use App\ScheduleCalculation\UseCase\ReadModel\VacationDay;
use App\ScheduleCalculation\Service\CalendarDates\CalendarDatesService;
use App\ScheduleCalculation\UseCase\ReadModel\TeamEventsRepository;
use App\ScheduleCalculation\UseCase\ReadModel\VacationRepository;
use App\ScheduleCalculation\UseCase\ReadModel\WorkerRepository;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use Exception;
use PharIo\Manifest\InvalidUrlException;

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
     * @var CalendarDatesService
     */
    private CalendarDatesService $calendarDatesService;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkerRepository $workerRepository
     * @param VacationRepository $vocationRepository
     * @param TeamEventsRepository $teamEventsRepository
     * @param CalendarDatesService $calendarDatesService
     */
    public function __construct(
        WorkerRepository $workerRepository,
        VacationRepository $vocationRepository,
        TeamEventsRepository $teamEventsRepository,
        CalendarDatesService $calendarDatesService
    ) {
        $this->workerRepository = $workerRepository;
        $this->vocationRepository = $vocationRepository;
        $this->teamEventsRepository = $teamEventsRepository;
        $this->calendarDatesService = $calendarDatesService;
    }

    /**
     * @param GetWorkersScheduleQuery $query
     * @return ScheduleReadModel[]
     * @throws Exception
     */
    public function handle(GetWorkersScheduleQuery $query): array {

        $calendarDates = $this->calendarDatesService
            ->getForPeriod($query->getStartDate(), $query->getEndDate());

        $vacationDays = $this->vocationRepository
            ->findByWorkerId($query->getWorkerId());

        $workerData = $this->workerRepository
            ->find($query->getWorkerId());

        if (empty($workerData)) throw new InvalidUrlException('Нет такого работника!');

        $workingDays = $this->getWorkingDays($workerData, $calendarDates, $vacationDays);

        $eventDays = $this->teamEventsRepository->findAll();

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
    }

    /**
     * @param array $workerData
     * @param CalendarDate[] $calendarDates
     * @param VacationDay[] $vacationDays
     * @return WorkingDay[]
     */
    private function getWorkingDays(
        array $workerData,
        array $calendarDates,
        array $vacationDays
    ): array {

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

    /**
     * @param WorkingDay[] $workingDays
     * @param EventDay[] $eventDays
     * @throws Exception
     */
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

                //TODO Добавить проверки для большей гибкости при различном времени начала и окончания мероприятий
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