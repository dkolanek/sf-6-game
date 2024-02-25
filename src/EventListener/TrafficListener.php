<?php

namespace App\EventListener;

use App\Service\TrafficService;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TrafficListener
{
    private TrafficService $traffic;

    public function __construct(TrafficService $traffic)
    {
        $this->traffic = $traffic;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $header = $event->getRequest()->headers->all();

        if ($header) {
            $this->traffic->record($header);
        }
    }
}
