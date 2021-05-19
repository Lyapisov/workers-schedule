<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\EventListeners;

use App\SharedKernel\Domain\Exceptions\ApplicationException;
use App\SharedKernel\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException ||
            $exception instanceof BadRequestException
        ) {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            ));

            return;
        }

        if ($exception instanceof NotFoundException)
        {
            $status = Response::HTTP_BAD_REQUEST;
            if ($event->getRequest()->getMethod() === Request::METHOD_GET) {
                $status = Response::HTTP_NOT_FOUND;
            }

            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                $status
            ));

            return;
        }

        if ($exception instanceof ApplicationException)
        {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            ));

            return;
        }

        if ($exception instanceof \DomainException)
        {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            ));

            return;
        }

        if ($exception instanceof UnauthorizedHttpException)
        {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                Response::HTTP_UNAUTHORIZED
            ));

            return;
        }

        if ($exception instanceof AccessDeniedHttpException)
        {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse([$exception->getMessage()]),
                Response::HTTP_FORBIDDEN
            ));

            return;
        }

        if ($exception instanceof \Throwable)
        {
            $event->setResponse(new JsonResponse(
                $this->createErrorResponse(
                    [
                        'Возникла неожиданная ошибка.' .
                        ' Пожайлуста, повторите запрос позднее.',
                    ]
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ));

            return;
        }
    }

    /**
     * @param array<string> $messages
     * @return mixed
     */
    private function createErrorResponse(array $messages)
    {
        return ['error' => ['messages' => $messages, 'code' => 1,]];
    }
}
