<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 25.07.16
 * Time: 11:55
 */

namespace TerraMonitoring\Web\Error;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
class UnhandledExceptionSubscriber implements EventSubscriberInterface
{
    /** @var bool */
    private $debug = false;
    /**
     * UnhandledExceptionSubscriber constructor.
     *
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }
    /** {@inheritdoc} */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $data = [
            'message' => $exception->getMessage(),
            'code'    => $exception->getCode(),
        ];
        if ($this->debug === true) {
            $data['details'] = $exception->getTraceAsString();
        }
        $event->setResponse(new JsonResponse($data));
    }
}