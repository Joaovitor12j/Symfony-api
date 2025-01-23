<?php

namespace App\EventSubscriber;

use App\Exception\HandleUserException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HandleUserException) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            $statusCode = ($exception->getCode() >= 100 && $exception->getCode() < 600)
                ? $exception->getCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            $response = new JsonResponse(
                ['mensagem' => $exception->getMessage()],
                $statusCode
            );

            $event->setResponse($response);
        }
    }
}
