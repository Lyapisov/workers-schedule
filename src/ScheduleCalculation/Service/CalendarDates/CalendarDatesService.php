<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Service\CalendarDates;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Сервис для получения списка дат с статусами о рабочем или нерабочем дне
 */
final class CalendarDatesService
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

    /**
     * @param string $startDate
     * @param string $endDate
     * @return CalendarDate[]
     */
    public function getForPeriod(
        string $startDate,
        string $endDate
    ) {

        $allDays = $this->generateDateInterval($startDate, $endDate);
        $allDaysStatus = $this->getAllDaysStatusByApi($startDate, $endDate);

        $daysWithStatus = array_combine($allDays, $allDaysStatus);

        $calendarDates = $this->getCalendarDates($daysWithStatus);

        return $calendarDates;
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

    /**
     * @param array $daysWithStatus
     * @return CalendarDate[]
     */
    private function getCalendarDates(array $daysWithStatus): array {

        $calendarDate = [];
        foreach ($daysWithStatus as $day => $isHoliday) {
            $calendarDate[] = new CalendarDate(
                DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $day . ' 00:00:00'),
                (bool)$isHoliday
            );
        }
        return $calendarDate;
    }

}