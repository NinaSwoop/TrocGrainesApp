<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Domain\Exception\EmailAlreadyUsedException;
use App\Domain\Exception\InvalidCredentialsException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error('An error occurred: '.$exception->getMessage(), [
            'exception' => $exception
        ]);

        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent($message);
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof EmailAlreadyUsedException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_CONFLICT
            );
        } elseif ($exception instanceof InvalidCredentialsException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_UNAUTHORIZED
            );
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
