<?php

namespace Brackets\AdvancedLogger\Listeners;

use Brackets\AdvancedLogger\Jobs\RequestLogJob;
use Brackets\AdvancedLogger\Services\Benchmark;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;

/**
 * Class RequestLoggerListenerHandler
 */
class RequestLoggerListenerHandler
{
    use DispatchesJobs;

    /**
     * @param RequestHandled $event
     * @throws \Exception
     */
    public function handle(RequestHandled $event): void
    {
        Benchmark::end(config('advanced-logger.request.benchmark', 'application'));

        if (!$this->excluded($event->request)) {
            $task = app(RequestLogJob::class, ['request' => $event->request, 'response' => $event->response]);
            $queueName = config('advanced-logger.request.queue');
            if (is_null($queueName)) {
                $task->handle();
            } else {
                $this->dispatch(is_string($queueName) ? $task->onQueue($queueName) : $task);
            }
        }
    }

    /**
     * Check if current path is not excluded
     *
     * @param Request $request
     * @return bool
     */
    protected function excluded(Request $request): bool
    {
        $excludedPaths = config('advanced-logger.request.excluded-paths');
        if (null === $excludedPaths || empty($excludedPaths)) {
            return false;
        }
        foreach ($excludedPaths as $excludedPath) {
            if ($request->is($excludedPath)) {
                return true;
            }
        }
        return false;
    }
}
