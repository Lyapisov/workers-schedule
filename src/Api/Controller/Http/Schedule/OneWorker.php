<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Schedule;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Класс получения графика работника
 * Class ListAction
 * @package App\ApiGateway\Controller\Http\Schedule
 */
final class OneWorker
{

    /**
     * @Route("/workers-schedule",
     *     name="workers-schedule",
     *     methods={"GET"}
     * )
     *
     * @return string
     */
    public function __invoke()
    {

    }

}