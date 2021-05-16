<?php
declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->em = $this->getEntityManager();
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

    public static function getEntityManager(): ?EntityManagerInterface
    {
        if (static::$kernel) {
            return static::$kernel
                ->getContainer()
                ->get('doctrine.orm.entity_manager')
                ;
        }

        return null;
    }

}
