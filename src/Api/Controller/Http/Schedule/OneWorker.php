<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Schedule;

use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleHandler;
use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Класс получения графика работника
 * Class ListAction
 * @package App\ApiGateway\Controller\Http\Schedule
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
     * @return string
     */
    public function __invoke(Request $request): JsonResponse
    {

        $readModel = $this->getWorkersScheduleHandler->handle(new GetWorkersScheduleQuery(
            $request->get('workerId', ''),
            $request->get('startDate', ''),
            $request->get('endDate', '')

        ));


        return new JsonResponse($readModel, JsonResponse::HTTP_OK);
    }

}