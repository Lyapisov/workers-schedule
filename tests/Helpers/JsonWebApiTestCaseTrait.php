<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;

trait JsonWebApiTestCaseTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    protected function createJsonClient(): KernelBrowser
    {
        return self::createClient([], ['CONTENT_TYPE' => 'application/json']);
    }

    /**
     * Creates a KernelBrowser.
     *
     * @param array $options An array of options to pass to the createKernel method
     * @param array $server  An array of server parameters
     *
     * @return KernelBrowser A KernelBrowser instance
     */
    protected static function createClient(array $options = [], array $server = [])
    {
        try {
            $client = self::$kernel->getContainer()->get('test.client');
        } catch (ServiceNotFoundException $e) {
//            var_dump($e->getMessage());
//            var_dump(getenv('APP_ENV'));
//            die;
            if (class_exists(KernelBrowser::class)) {
                throw new \LogicException('You cannot create the client used in functional tests if the "framework.test" config is not set to true.');
            }
            throw new \LogicException('You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit"');
        }

        $client->setServerParameters($server);

        return self::getClient($client);
    }

    /**
     * Форматирует данные в формате json, делая их более читаемыми.
     *
     * @param $content
     * @return string
     */
    private function prettifyJson($content): string
    {
        return json_encode(
            json_decode($content),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    private static function getClient(AbstractBrowser $newClient = null): ?AbstractBrowser
    {
        static $client;

        if (0 < \func_num_args()) {
            return $client = $newClient;
        }

        if (!$client instanceof AbstractBrowser) {
            static::fail(sprintf('A client must be set to make assertions on it. Did you forget to call "%s::createClient()"?', __CLASS__));
        }

        return $client;
    }
}