<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Domain\Exception\EmailAlreadyUsedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Psr\Log\LoggerInterface;

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
        $this->logger->error('An error occurred: ' . $exception->getMessage());

        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent($message);
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        if ($exception instanceof HttpExceptionInterface || $exception instanceof EmailAlreadyUsedException) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }
        else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}