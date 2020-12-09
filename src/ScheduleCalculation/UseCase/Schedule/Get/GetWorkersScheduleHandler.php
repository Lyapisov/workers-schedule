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
     * @var WorkersScheduleReadModelRepository
     */
    private WorkersScheduleReadModelRepository $workerReadModelRepository;

    /**
     * @var VocationReadModelRepository
     */
    private VocationReadModelRepository $vocationReadModelRepository;

    /**
     * @var TeamEventsReadModelRepository
     */
    private TeamEventsReadModelRepository $teamEventsReadModelRepository;

    /**
     * @var Holidays
     */
    private Holidays $holidaysService;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkersScheduleReadModelRepository $workerReadModelRepository
     * @param VocationReadModelRepository $vocationReadModelRepository
     * @param TeamEventsReadModelRepository $teamEventsReadModelRepository
     * @param Holidays $holidaysService
     */
    public function __construct(
        WorkersScheduleReadModelRepository $workerReadModelRepository,
        VocationReadModelRepository $vocationReadModelRepository,
        TeamEventsReadModelRepository $teamEventsReadModelRepository,
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