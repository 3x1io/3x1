<?php

namespace Brackets\AdvancedLogger\Formatters;

use Brackets\AdvancedLogger\Services\Benchmark;
use Monolog\Formatter\LineFormatter;

/**
 * Class LineWithHashFormatter
 */
class LineWithHashFormatter extends LineFormatter
{
    public const KEY = 'hash';

    /**
     * @param array $record
     * @return array|mixed|string|string[]|void|null
     */
    public function format(array $record): string
    {
        $output = parent::format($record);
        if (false !== strpos($output, '%' . self::KEY . '%')) {
            $output = str_replace(
                '%' . self::KEY . '%',
                $this->stringify($this->getRequestHash()),
                $output
            );
        }
        return $output;
    }

    /**
     * Get request hash
     *
     * @return string|null
     */
    protected function getRequestHash(): ?string
    {
        try {
            return Benchmark::hash(config('advanced-logger.request.benchmark', 'application'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
