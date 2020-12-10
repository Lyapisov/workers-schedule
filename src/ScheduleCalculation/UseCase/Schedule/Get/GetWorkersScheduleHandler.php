<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

use App\ScheduleCalculation\Service\Holidays\Holidays;

/**
 * Обработчик сценария получения графика работы
 *
 * Class GetWorkersScheduleHandler
 * @package App\ScheduleCalculation\UseCase\Schedule\Get
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
     * @var Holidays
     */
    private Holidays $holidaysService;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkerRepository $workerRepository
     * @param VacationRepository $vocationRepository
     * @param TeamEventsRepository $teamEventsRepository
     * @param Holidays $holidaysService
     */
    public function __construct(
        WorkerRepository $workerRepository,
        VacationRepository $vocationRepository,
        TeamEventsRepository $teamEventsRepository,
        Holidays $holidaysService
    ) {
        $this->workerRepository = $workerRepository;
        $this->vocationRepository = $vocationRepository;
        $this->teamEventsRepository = $teamEventsRepository;
        $this->holidaysService = $holidaysService;
    }


    public function handle(GetWorkersScheduleQuery $query):array {

        $workersHours = $this->workerRepository->find($query->getWorkerId());

        $teamEvents = $this->teamEventsRepository->findAll();

        $vocation = $this->vocationRepository
            ->findByWorkerId($query->getWorkerId());

        $officialHolidays = $this->holidaysService
            ->getForPeriod(
                $query->getStartDate(),
                $query->getEndDate()
            );

        return $officialHolidays;

    }
}