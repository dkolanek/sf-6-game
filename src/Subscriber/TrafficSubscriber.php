<?php

namespace App\Subscriber;

use App\Service\TrafficService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TrafficSubscriber implements EventSubscriberInterface
{

    private TrafficService $traffic;

    public function __construct(TrafficService $traffic)
    {
        $this->traffic = $traffic;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $header = $event->getRequest()->headers->all();

        if ($header) {
            $this->traffic->record($header);
        }
    }
}
