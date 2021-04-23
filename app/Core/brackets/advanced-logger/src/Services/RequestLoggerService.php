<?php

namespace Brackets\AdvancedLogger\Services;

use Brackets\AdvancedLogger\Interpolations\RequestInterpolation;
use Brackets\AdvancedLogger\Interpolations\ResponseInterpolation;
use Brackets\AdvancedLogger\Loggers\RequestLogger;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;

/**
 * Class RequestLoggerService
 */
class RequestLoggerService
{
    /**
     *
     */
    protected const LOG_CONTEXT = 'RESPONSE';
    /**
     * @var array
     */
    protected $formats = [
        'full' => '{request-hash} | HTTP/{http-version} {status} | {remote-addr} | {user} | {method} {url} {query} | {response-time} s | {user-agent} | {referer}',
        'combined' => '{remote-addr} - {remote-user} [{date}] "{method} {url} HTTP/{http-version}" {status} {content-length} "{referer}" "{user-agent}"',
        'common' => '{remote-addr} - {remote-user} [{date}] "{method} {url} HTTP/{http-version}" {status} {content-length}',
        'dev' => '{method} {url} {status} {response-time} s - {content-length}',
        'short' => '{remote-addr} {remote-user} {method} {url} HTTP/{http-version} {status} {content-length} - {response-time} s',
        'tiny' => '{method} {url} {status} {content-length} - {response-time} s'
    ];
    /**
     * @var RequestInterpolation
     */
    protected $requestInterpolation;
    /**
     * @var ResponseInterpolation
     */
    protected $responseInterpolation;
    /**
     * @var RequestLogger
     */
    protected $logger;

    /**
     * RequestLoggerService constructor.
     *
     * @param RequestLogger $logger
     * @param RequestInterpolation $requestInterpolation
     * @param ResponseInterpolation $responseInterpolation
     */
    public function __construct(
        RequestLogger $logger,
        RequestInterpolation $requestInterpolation,
        ResponseInterpolation $responseInterpolation
    ) {
        $this->logger = $logger;
        $this->requestInterpolation = $requestInterpolation;
        $this->responseInterpolation = $responseInterpolation;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function log(Request $request, Response $response): void
    {
        $this->requestInterpolation->setRequest($request);

        $this->responseInterpolation->setResponse($response);

        if (config('advanced-logger.request.enabled')) {
            $format = config('advanced-logger.request.format', 'full');
            $format = Arr::get($this->formats, $format, $format);

            $message = $this->responseInterpolation->interpolate($format);
            $message = $this->requestInterpolation->interpolate($message);

            $this->logger->log(config('advanced-logger.request.level', 'info'), $message, [
                static::LOG_CONTEXT
            ]);
        }
    }
}
