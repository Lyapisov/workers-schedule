<?php

declare(strict_types=1);

namespace Api\Controller\Http\UserAccess;

use App\Tests\ControllerTest;
use Symfony\Component\HttpFoundation\Response;

final class SignUpTest extends ControllerTest
{
    private const USER_LOGIN = 'Kenny';
    private const USER_EMAIL = 'kenny@gmail.com';
    private const USER_PASSWORD = 'kenny2000;)';
    private const USER_PRODUCER_ROLE = 'producer';
    private const USER_MUSICIAN_ROLE = 'musician';
    private const USER_FAN_ROLE = 'fan';

    public function testSuccessful()
    {
        $this->client->request(
            'POST',
            self::query(),
            [
                'login' => self::USER_LOGIN,
                'email' => self::USER_EMAIL,
                'password' => self::USER_PASSWORD,
                'role' => self::USER_FAN_ROLE,
            ]
        );

        $expectedResponseContent =
            [
                'user' =>
                    [
                        'login' => self::USER_LOGIN,
                        'email' => self::USER_EMAIL,
                        'role' => self::USER_FAN_ROLE,
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

    private static function query(): string
    {

        return '/sign-up';
    }
}