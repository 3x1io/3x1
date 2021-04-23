<?php

namespace Brackets\AdvancedLogger\LogCustomizers;

use Brackets\AdvancedLogger\Formatters\LineWithHashFormatter;

/**
 * Class HashLogCustomizer
 */
class HashLogCustomizer
{
    /**
     * Customize the given logger instance.
     *
     * @param \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(app(
                LineWithHashFormatter::class,
                ['format' => "[%datetime%] %hash% %channel%.%level_name%: %message% %context% %extra%\n"]
            ));
        }
    }
}
