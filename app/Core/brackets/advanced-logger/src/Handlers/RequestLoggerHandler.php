<?php

namespace Brackets\AdvancedLogger\Handlers;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * Class RequestLoggerHandler
 */
class RequestLoggerHandler extends RotatingFileHandler
{
    /**
     * RequestLoggerHandler constructor.
     *
     * @param null $filename
     * @param int $maxFiles
     * @param int $level
     * @param bool $bubble
     * @param null $filePermission
     * @param bool $useLocking
     */
    public function __construct(
        $filename = null,
        $maxFiles = 0,
        $level = Logger::DEBUG,
        $bubble = true,
        $filePermission = null,
        $useLocking = false
    ) {
        $filename = !is_null($filename) ? $filename : config(
            'advanced-logger.request.file',
            storage_path('logs/request.log')
        );
        parent::__construct($filename, $maxFiles, $level, $bubble, $filePermission, $useLocking);
    }
}
