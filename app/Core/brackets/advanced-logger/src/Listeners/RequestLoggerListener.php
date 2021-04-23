<?php

namespace Brackets\AdvancedLogger\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;

/**
 * Class RequestLoggerListener
 */
class RequestLoggerListener
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher|Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            RequestHandled::class,
            RequestLoggerListenerHandler::class
        );
    }
}
