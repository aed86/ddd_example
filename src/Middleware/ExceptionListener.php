<?php

declare(strict_types = 1);

namespace App\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @throws \JsonException
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();
        $response->setContent($exception->getMessage());

        $data = [
            'success' => false,
            'error' => $exception->getMessage(),
        ];

        //TODO: it will work after proper throwing exceptions between layers
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response->setContent(json_encode($data, JSON_THROW_ON_ERROR));
        $event->setResponse($response);
    }
}
