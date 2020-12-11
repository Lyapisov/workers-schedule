<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Schedule;

use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleHandler;
use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleQuery;
use App\ScheduleCalculation\UseCase\Schedule\Get\ScheduleReadModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Класс получения графика работника
 */
final class OneWorker
{

    private GetWorkersScheduleHandler $getWorkersScheduleHandler;

    /**
     * OneWorker constructor.
     * @param GetWorkersScheduleHandler $getWorkersScheduleHandler
     */
    public function __construct(GetWorkersScheduleHandler $getWorkersScheduleHandler)
    {
        $this->getWorkersScheduleHandler = $getWorkersScheduleHandler;
    }

    /**
     * @Route("/workers-schedule",
     *     name="workers-schedule",
     *     methods={"GET"}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {

        $readModel = $this->getWorkersScheduleHandler->handle(new GetWorkersScheduleQuery(
            $request->get('workerId', ''),
            $request->get('startDate', ''),
            $request->get('endDate', '')
        ));

        $responseContent = [
            'schedule' => array_map(fn(ScheduleReadModel $readModel) => [
                'day' => $readModel->getDay()->format('Y-m-d'),
                'timeRanges' => [
                    [
                        'start' => $readModel->getStartBeforeBreak()->format('H:i:s'),
                        'end' => $readModel->getEndBeforeBreak()->format('H:i:s')
                    ],
                    [
                        'start' => $readModel->getStartAfterBreak()->format('H:i:s'),
                        'end' => $readModel->getEndAfterBreak()->format('H:i:s')
                    ],
                ]
            ], $readModel)
        ];

        return new JsonResponse($responseContent, JsonResponse::HTTP_OK);
    }

}