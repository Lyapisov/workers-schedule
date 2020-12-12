<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\HolidaySchedule;

use App\ScheduleCalculation\UseCase\HolidaySchedule\Get\GetHolidayScheduleHandler;
use App\ScheduleCalculation\UseCase\Schedule\Get\GetWorkersScheduleQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Класс получения выходного графика работника
 */
final class OneWorker
{
    /**
     * @var GetHolidayScheduleHandler
     */
    private GetHolidayScheduleHandler $getHolidayScheduleHandler;

    /**
     * OneWorker constructor.
     * @param GetHolidayScheduleHandler $getHolidayScheduleHandler
     */
    public function __construct(GetHolidayScheduleHandler $getHolidayScheduleHandler)
    {
        $this->getHolidayScheduleHandler = $getHolidayScheduleHandler;
    }

    /**
     * @Route("/worker-holiday-schedule",
     *         name="worker-holiday-schedule",
     *         methods={"GET"}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $readModel = $this->getHolidayScheduleHandler->handle(new GetWorkersScheduleQuery(
            $request->get('workerId', ''),
            $request->get('startDate', ''),
            $request->get('endDate', '')
        ));

        $content = [];

        foreach ($readModel as $item){
            if ($item->isFullHoliday()) {
                $content[] = [
                    'day' => $item->getDate()->format('Y-m-d'),
                    'timeRanges' => [
                        [
                            'start' => $item->getFullHolidayStart()->format('H:i'),
                            'end' => $item->getFullHolidayEnd()->format('H:i')
                        ]
                    ]
                ];
            }

            $content[] = [
                'day' => $item->getDate()->format('Y-m-d'),
                'timeRanges' => [
                    [
                        'start' => $item->getStartBeforeWorking()->format('H:i'),
                        'end' => $item->getEndBeforeWorking()->format('H:i')
                    ],
                    [
                        'start' => $item->getStartBreak()->format('H:i'),
                        'end' => $item->getEndBreak()->format('H:i')
                    ],
                    [
                        'start' => $item->getStartAfterWorking()->format('H:i'),
                        'end' => $item->getEndAfterWorking()->format('H:i')
                    ]
                ]
            ];
        }

        $responseContent = [
            'holidaySchedule' => $content
        ];

        return new JsonResponse($responseContent, Response::HTTP_OK);
    }
}