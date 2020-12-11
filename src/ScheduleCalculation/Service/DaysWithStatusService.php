<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Service;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class DaysWithStatusService
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * Calendar constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getForPeriod(
        string $startDate,
        string $endDate
    ) {

        $allDays = $this->generateDateInterval($startDate, $endDate);
        $allDaysStatus = $this->getAllDaysStatusByApi($startDate, $endDate);

        $daysWithStatus = array_combine($allDays, $allDaysStatus);
//        $holidayDays = $this->getHolidayDaysOnly($daysWithStatus);

        return $daysWithStatus;

    }

    private function getAllDaysStatusByApi(string $startDate, string $endDate): array {

        $response = $this->client->request(
            'GET',
            'https://isdayoff.ru/api/getdata?date1='
            . $startDate . '&date2=' . $endDate
            . '&pre=0&delimeter=%3B&covid=0'
        );
        $resultApi = $response->getContent();
        $resultApi = explode(";", $resultApi);
        return $resultApi;
    }

    private function generateDateInterval(string $startDate, string $endDate): array {

        $begin = new DateTimeImmutable($startDate);
        $end = new DateTimeImmutable($endDate);
        $end = $end->modify('+1 day');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $dateInterval = [];

        foreach ($period as $dt) {
            $dateInterval[] = $dt->format("Y-m-d");
        }

        return $dateInterval;
    }

    private function getHolidayDaysOnly(array $allDays): array {

        $holidayDays = $allDays;

        foreach($holidayDays as $day => $status){
            if ($status == 0){
                unset($holidayDays[$day]);
            }
        }
        return $holidayDays;
    }

}