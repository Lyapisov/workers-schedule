<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\Tests\ControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Helpers\AssertUUIDTrait;

final class SignUpTest extends ControllerTest
{
    use AssertUUIDTrait;

    private const USER_LOGIN = 'Kenny';
    private const USER_EMAIL = 'kenny@gmail.com';
    private const USER_PASSWORD = 'kenny2000;)';
    private const USER_PRODUCER_ROLE = 'producer';
    private const USER_MUSICIAN_ROLE = 'musician';
    private const USER_FAN_ROLE = 'fan';

    public function testSuccessful()
    {
        copy('src/FilesDataBase/DataBase/UserAccess/Users/users.csv', 'src/FilesDataBase/DataBase/UserAccess/Users/users-copy.csv');

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

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $responseContent = json_decode($responseContent, true);

        $this->assertUuid($responseContent['user']['annualToken']);
        $this->assertUuid($responseContent['user']['temporaryToken']);
        $this->assertEquals(self::USER_LOGIN, $responseContent['user']['login']);
        $this->assertEquals(self::USER_EMAIL, $responseContent['user']['email']);
        $this->assertEquals(self::USER_FAN_ROLE, $responseContent['user']['role']);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        copy('src/FilesDataBase/DataBase/UserAccess/Users/users-copy.csv', 'src/FilesDataBase/DataBase/UserAccess/Users/users.csv');
        unlink('src/FilesDataBase/DataBase/UserAccess/Users/users-copy.csv');
    }

    private static function query(): string
    {
        return '/sign-up';
    }
}
