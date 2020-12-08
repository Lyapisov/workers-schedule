<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\UseCase\Schedule\Get;

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
    private WorkersScheduleReadModelRepository $readModelRepository;

    /**
     * GetWorkersScheduleHandler constructor.
     * @param WorkersScheduleReadModelRepository $readModelRepository
     */
    public function __construct(WorkersScheduleReadModelRepository $readModelRepository)
    {
        $this->readModelRepository = $readModelRepository;
    }

    public function handle(GetWorkersScheduleQuery $query): array {
        return $this->readModelRepository->find(
            $query->getWorkerId(),
            $query->getStartDate(),
            $query->getEndDate()
        );
    }
}