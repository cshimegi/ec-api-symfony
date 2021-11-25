<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use App\Exception\ParameterNotFoundException;
use Throwable;

class ParameterNotFoundExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            "kernel.exception" => "onKernelException",
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($this->isBadRequestException($exception)) {
            $event->setResponse($this->newBadRequestJsonResponse($exception));
        }
    }

    private function isBadRequestException(Throwable $exception): bool
    {
        return $exception instanceof ParameterNotFoundException;
    }

    private function newBadRequestJsonResponse(Throwable $exception): JsonResponse
    {
        return new JsonResponse(
            [
                "error" => $exception->getMessage(),
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
