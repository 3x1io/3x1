<?php

namespace Brackets\AdminTranslations\Exceptions;

use Brackets\AdminTranslations\Translation;
use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @param string $className
     * @return InvalidConfiguration
     */
    public static function invalidModel(string $className): self
    {
        return new static("You have configured an invalid class `{$className}`.".
            'A valid class extends '.Translation::class.'.');
    }
}
