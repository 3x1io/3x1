<?php

namespace Brackets\AdvancedLogger\Jobs;

use Brackets\AdvancedLogger\Services\RequestLoggerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RequestLogJob
 */
class RequestLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;

    /**
     * RequestLogJob constructor.
     *
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $requestLoggerService = app(RequestLoggerService::class);
        $requestLoggerService->log($this->request, $this->response);
    }
}
