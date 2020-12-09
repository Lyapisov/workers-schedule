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
    private WorkerRepository $workerReadModelRepository;

    /**
     * @var VacationRepository
     */
    private VacationRepository $vocationReadModelRepository;

    /**
     * @var TeamEventsRepository
     */
    private TeamEventsRepository $teamEventsReadModelRepository;

    /**
     * @var Holidays
     */
    private Holidays $holidaysService;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkerRepository $workerReadModelRepository
     * @param VacationRepository $vocationReadModelRepository
     * @param TeamEventsRepository $teamEventsReadModelRepository
     * @param Holidays $holidaysService
     */
    public function __construct(
        WorkerRepository $workerReadModelRepository,
        VacationRepository $vocationReadModelRepository,
        TeamEventsRepository $teamEventsReadModelRepository,
        Holidays $holidaysService
    ) {
        $this->workerReadModelRepository = $workerReadModelRepository;
        $this->vocationReadModelRepository = $vocationReadModelRepository;
        $this->teamEventsReadModelRepository = $teamEventsReadModelRepository;
        $this->holidaysService = $holidaysService;
    }


    public function handle(GetWorkersScheduleQuery $query):array {

        $workersHours = $this->workerReadModelRepository->find($query->getWorkerId());

        $teamEvents = $this->teamEventsReadModelRepository->findAll();

        $vocation = $this->vocationReadModelRepository
            ->findByWorkerId($query->getWorkerId());

        $officialHolidays = $this->holidaysService
            ->getForPeriod(
                $query->getStartDate(),
                $query->getEndDate()
            );


    }
}