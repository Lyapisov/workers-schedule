<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Schedule;

use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleHandler;
use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleQuery;
use App\ScheduleCalculation\UseCase\Schedule\Get\ScheduleReadModel;
use PharIo\Manifest\InvalidUrlException;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Класс получения графика работника
 */
final class GetWorkingPeriods
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
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {

        try {

            $workerId = $request->get('workerId', '');
            $startDate = $request->get('startDate', '');
            $endDate = $request->get('endDate', '');

            if (empty($workerId) || empty($startDate) || empty($endDate)) {
                throw new InvalidUrlException('Введены не все данные!');
            }

            $readModel = $this->getWorkersScheduleHandler->handle(new GetWorkersScheduleQuery(
                $workerId,
                $startDate,
                $endDate
            ));

            $responseContent = [
                'schedule' => array_map(fn(ScheduleReadModel $readModel) => [
                    'day' => $readModel->getDay()->format('Y-m-d'),
                    'timeRanges' => [
                        [
                            'start' => $readModel->getStartBeforeBreak()->format('H:i'),
                            'end' => $readModel->getEndBeforeBreak()->format('H:i')
                        ],
                        [
                            'start' => $readModel->getStartAfterBreak()->format('H:i'),
                            'end' => $readModel->getEndAfterBreak()->format('H:i')
                        ],
                    ]
                ], $readModel)
            ];

            return new JsonResponse($responseContent, JsonResponse::HTTP_OK);

        } catch (InvalidUrlException $exception){

            $error = [
                'error' => [
                    'messages' => $exception->getMessage(),
                ],
            ];

            return new JsonResponse($error,JsonResponse::HTTP_BAD_REQUEST );
        }
    }

}