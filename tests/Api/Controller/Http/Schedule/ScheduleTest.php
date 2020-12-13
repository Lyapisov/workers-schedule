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
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-10 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-11 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
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
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithVacationPeriod() {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200131', '20200217')
        );

        $expectedResponseContent =
            [
                'schedule' => [
                    [
                        'day' => '2020-01-31',
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
                        'day' => '2020-02-17',
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
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithEventPeriod() {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-09 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-10 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200108', '20200113')
        );

        $expectedResponseContent =
            [
                'schedule' => [
                    [
                        'day' => '2020-01-09',
                        'timeRanges' => [
                            [
                                'start' => '08:00',
                                'end' => '13:00'
                            ],
                            [
                                'start' => '14:00',
                                'end' => '15:00'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-01-10',
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
                        'day' => '2020-01-13',
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
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithVacationAndEventPeriod() {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-10 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-20 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-09 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-09 18:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200108', '20200113')
        );

        $expectedResponseContent =
            [
                'schedule' => [
                    [
                        'day' => '2020-01-09',
                        'timeRanges' => [
                            [
                                'start' => '08:00',
                                'end' => '13:00'
                            ],
                            [
                                'start' => '14:00',
                                'end' => '15:00'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithNotOneVacationPeriod() {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '09:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '18:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '15:00:00'),
            [self::FIRST_VACATION_ID, self::SECOND_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-15 23:59:59')
        );

        $secondVacation = new Vacation(
            $id = self::SECOND_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-17 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-10-31 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-09 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-09 18:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($secondVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200930', '20201102')
        );

        $expectedResponseContent =
            [
                'schedule' => [
                    [
                        'day' => '2020-09-30',
                        'timeRanges' => [
                            [
                                'start' => '09:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '15:00',
                                'end' => '18:00'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-10-16',
                        'timeRanges' => [
                            [
                                'start' => '09:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '15:00',
                                'end' => '18:00'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-11-02',
                        'timeRanges' => [
                            [
                                'start' => '09:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '15:00',
                                'end' => '18:00'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testIfEmptyQuery() {

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '', '')
        );

        $expectedResponseContent =
            [
                'error' => [
                    'messages' => 'Введены не все данные!',
                ],
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        );
    }

    public function testIfNotWorker() {

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20201212', '20201213')
        );

        $expectedResponseContent =
            [
                'error' => [
                    'messages' => 'Нет такого работника!',
                ],
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        );
    }

    private static function formUrl(
        string $workerId,
        string $startDate,
        string $endDate
    ): string {
        return '/workers-schedule?workerId=' . $workerId . '&startDate=' . $startDate . '&endDate=' . $endDate;
    }

}