<?php

declare(strict_types=1);

namespace App\ScheduleCalculation\Service\Holidays;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Holidays
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

//        $startDate = $startDate->format('Ymd');
//        $endDate = $endDate->format('Ymd');

        $response = $this->client->request(
            'GET',
            'https://isdayoff.ru/api/getdata?date1='
            . $startDate . '&date2=' . $endDate
            . '&pre=0&delimeter=%3B&covid=0'
        );
        $content = $response->getContent();

        return $content;

    }

}