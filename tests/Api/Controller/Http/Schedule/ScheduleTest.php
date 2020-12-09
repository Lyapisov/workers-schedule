<?php

declare(strict_types=1);

use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;

final class ScheduleTest extends KernelTestCase
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * ScheduleTest constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    public function testSuccessful() {

        $this->client->request(
            'GET',
            self::formUrl('20201010', '20201110')
        );

        /**
         * @var Response $responce
         */
        $responce = $this->client->getResponse();

        $actualContent = trim($responce->getContent());
        $expectedContent = trim(json_encode($expectedResponseBody));
        $this->assertContent(
            $this->prettifyJson($actualContent),
            $this->prettifyJson($expectedContent)
        );

    }

    private static function formUrl(string $startDate, string $endDate): string
    {
        return '/workers-schedule/?startDate=' . $startDate . '&endDate=' . $endDate;
    }
}