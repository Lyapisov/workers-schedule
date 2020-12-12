<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Schedule;

use App\Tests\ControllerTest;
use App\ScheduleCalculation\Entity\TeamEvent;
use App\ScheduleCalculation\Entity\Vacation;
use App\ScheduleCalculation\Entity\Worker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use DateTimeImmutable;


final class ScheduleTest extends ControllerTest
{

    const FIRST_WORKER_ID = 'idWorker1';
    const FIRST_VACATION_ID = 'idVacation1';
    const SECOND_VACATION_ID = 'idVacation2';
    const FIRST_TEAM_EVENT_ID = 'idTeamEvent1';

    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    public function testSuccessful() {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID, self::SECOND_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $secondVacation = new Vacation(
            $id = self::SECOND_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-06-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-06-14 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-10 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-11 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($secondVacation);
        $this->saveEntity($firstTeamEvent);


        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20201012', '20201013')
        );

        $expectedResponseContent =
            [
                'schedule' => [
                    [
                        'day' => '2020-10-12',
                        'timeRanges' => [
                            [
                                'start' => '08:00',
                                'end' => '13:00'
                            ],
                            [
                                'start' => '14:00',
                                'end' => '17:00'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-10-13',
                        'timeRanges' => [
                            [
                                'start' => '08:00',
                                'end' => '13:00'
                            ],
                            [
                                'start' => '14:00',
                                'end' => '17:00'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $response);

//        $this->assertEquals(
//            Response::HTTP_OK,
//            $response->getStatusCode()
//        );

    }

    private static function formUrl(
        string $workerId,
        string $startDate,
        string $endDate
    ): string {
        return '/workers-schedule?workerId=' . $workerId . '&startDate=' . $startDate . '&endDate=' . $endDate;
    }

}