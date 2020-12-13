<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\HolidaySchedule\Get;

use App\ScheduleCalculation\Service\CalendarDates\CalendarDate;
use App\ScheduleCalculation\UseCase\ReadModel\Breakfast;
use App\ScheduleCalculation\UseCase\ReadModel\EventDay;
use App\ScheduleCalculation\UseCase\ReadModel\VacationDay;
use App\ScheduleCalculation\Service\CalendarDates\CalendarDatesService;
use App\ScheduleCalculation\UseCase\ReadModel\TeamEventsRepository;
use App\ScheduleCalculation\UseCase\ReadModel\VacationRepository;
use App\ScheduleCalculation\UseCase\ReadModel\WorkerRepository;
use DateTimeImmutable;

/**
 * Обработчик сценария получения выходного графика работника
 */
final class GetHolidayScheduleHandler
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
     * @param GetHolidayScheduleQuery $query
     * @return HolidayScheduleReadModel[]
     * @throws \Exception
     */
    public function handle(GetHolidayScheduleQuery $query): array {

        $calendarDates = $this->calendarDatesService
            ->getForPeriod($query->getStartDate(), $query->getEndDate());

        $vacationDays = $this->vocationRepository->findByWorkerId($query->getWorkerId());

        $workerData = $this->workerRepository->find($query->getWorkerId());

        $holidayDays = $this->getHolidayDays($workerData, $calendarDates, $vacationDays);

        $eventDays = $this->teamEventsRepository->findAll();

        $this->correctHoliday($holidayDays, $eventDays);

        $readModel = [];
        foreach ($holidayDays as $day) {
            if ($day->isFullHoliday()) {
                $readModel[] = HolidayScheduleReadModel::ifFullHoliday(
                    $day->getDate(),
                    new DateTimeImmutable('00:00:00'),
                    new DateTimeImmutable('23:59:59')
                );
                continue;
            }

            $readModel[] = HolidayScheduleReadModel::ifPartHoliday(
                $day->getDate(),
                $day->getHolidayHours()->getStartBeforeWorking(),
                $day->getHolidayHours()->getEndBeforeWorking(),
                $day->getBreakfast()->getStart(),
                $day->getBreakfast()->getEnd(),
                $day->getHolidayHours()->getStartAfterWorking(),
                $day->getHolidayHours()->getEndAfterWorking(),
            );
        }
        return $readModel;
    }

    /**
     * @param array $workerData
     * @param CalendarDate[] $calendarDates
     * @param VacationDay[] $vacationDays
     * @return HolidayPeriod[]
     */
    private function getHolidayDays(
        array $workerData,
        array $calendarDates,
        array $vacationDays
    ): array {

        $holidayDays = [];
        foreach ($calendarDates as $date) {
            $countVacationDay = 0;
            foreach ($vacationDays as $vacationDay) {

                if ($date->isHoliday()) {
                    $holidayDays[] = HolidayPeriod::ifFullHoliday(
                        $date->getValue(),
                        $isFullHoliday = true
                    );
                    break 1;
                }

                if ($date->getValue() == $vacationDay->getDate()) {

                    $holidayDays[] = HolidayPeriod::ifFullHoliday(
                        $date->getValue(),
                        $isFullHoliday = true
                    );
                    break 1;
                }

                $countVacationDay++;
                if($countVacationDay == count($vacationDays)) {

                    $holidayDays[] = HolidayPeriod::ifPartHoliday(
                        $date->getValue(),
                        new HolidayHours(
                            new DateTimeImmutable('00:00:00'),
                            $workerData[0]['startTime'],
                            $workerData[0]['endTime'],
                            new DateTimeImmutable('23:59:59')
                        ),
                        new Breakfast(
                            $workerData[0]['startBreak'],
                            $workerData[0]['endBreak'],
                        ),
                        $isFullHoliday = false
                    );
                }
            }
        }
        return $holidayDays;
    }

    /**
     * @param HolidayPeriod[] $holidayDays
     * @param EventDay[] $eventDays
     */
    private function correctHoliday(array $holidayDays, array $eventDays) {
        foreach ($holidayDays as $holidayDay) {
            foreach ($eventDays as $eventDay) {

                if ($holidayDay->isFullHoliday()) break 1;

                $holidayDayWithoutHours = new DateTimeImmutable($holidayDay->getDate()->format('Y-m-d'));
                $eventDayWithoutHours = new DateTimeImmutable($eventDay->getDate()->format('Y-m-d'));

                $startEventDay = new DateTimeImmutable($eventDay->getStart()->format('H:i:s'));
                $endEventDay = new DateTimeImmutable($eventDay->getEnd()->format('H:i:s'));
                $startBeforeWorking = new DateTimeImmutable($holidayDay->getHolidayHours()->getStartBeforeWorking()->format('H:i:s'));
                $endBeforeWorking = new DateTimeImmutable($holidayDay->getHolidayHours()->getEndBeforeWorking()->format('H:i:s'));
                $startAfterWorking = new DateTimeImmutable($holidayDay->getHolidayHours()->getStartAfterWorking()->format('H:i:s'));
                $endAfterWorking = new DateTimeImmutable($holidayDay->getHolidayHours()->getEndAfterWorking()->format('H:i:s'));
                $startBreak = new DateTimeImmutable($holidayDay->getBreakfast()->getStart()->format('H:i:s'));
                $endBreak = new DateTimeImmutable($holidayDay->getBreakfast()->getEnd()->format('H:i:s'));

                //TODO Добавить проверки для большей гибкости при различном времени начала и окончания мероприятий
                if ( $holidayDayWithoutHours == $eventDayWithoutHours ) {

                    if ($startEventDay > $endBeforeWorking && $startEventDay < $startBreak) {
                        $holidayDay->getHolidayHours()->setStartAfterWorking($startEventDay);
                    }

                    if ($startEventDay < $startAfterWorking && $startEventDay > $endBreak) {
                        $holidayDay->getHolidayHours()->setStartAfterWorking($startEventDay);
                    }

                    if ($startEventDay < $startBeforeWorking && $endEventDay > $startAfterWorking){
                        $holidayDay->setIsFullHoliday(true);
                    }
                }
            }
        }
    }

}