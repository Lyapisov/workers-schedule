<?php
declare(strict_types=1);

namespace App\Tests;

use App\Tests\Helpers\JsonWebApiTestCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    use JsonWebApiTestCaseTrait;

    protected function setUp() {

        parent::setUp();
        static::bootKernel();
        $this->client = $this->createJsonClient();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void {

        $this->em->getConnection()->rollback();
        $this->em->close();
        parent::tearDown();
    }

    protected function saveEntity(object $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * Форматирует данные в формате json, делая их более читаемыми.
     *
     * @param $content
     * @return string
     */
    protected function prettifyJson($content): string
    {
        return json_encode(
            json_decode($content),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

}