<?php

namespace Brackets\AdvancedLogger\Loggers;

use Psr\Log\LoggerInterface;
use RuntimeException;

/**
 * Class BaseRequestLogger
 */
class RequestLogger implements LoggerInterface
{
    /**
     * @var \Monolog\Logger;
     */
    protected $monolog;

    /**
     * BaseRequestLogger constructor.
     */
    public function __construct()
    {
        if (version_compare(app()->version(), '5.5.99', '<=')) {
            $this->monolog = clone app('log')->getMonolog();
        } else {
            $this->monolog = app('log')->driver()->getLogger();
        }
        if (config('advanced-logger.request.enabled') && $handlers = config('advanced-logger.request.handlers')) {
            if (count($handlers)) {
                $this->monolog->popHandler();
                foreach ($handlers as $handler) {
                    if (class_exists($handler)) {
                        $this->monolog->pushHandler(app($handler));
                    } else {
                        throw new RuntimeException("Handler class [{$handler}] does not exist");
                    }
                }
            }
        }
    }

    /**
     * Log an alert message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->monolog->alert($message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->monolog->critical($message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->monolog->error($message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->monolog->warning($message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->monolog->notice($message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->monolog->info($message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->monolog->debug($message, $context);
    }


    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->monolog->emergency($message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->monolog->log($level, $message, $context);
    }

    /**
     * Register a file log handler.
     *
     * @param string $path
     * @param string $level
     * @return void
     */
    public function useFiles($path, $level = 'debug')
    {
    }

    /**
     * Register a daily file log handler.
     *
     * @param string $path
     * @param int $days
     * @param string $level
     * @return void
     */
    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
    }
}
