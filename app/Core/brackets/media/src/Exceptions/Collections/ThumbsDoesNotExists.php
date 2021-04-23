<?php

namespace Brackets\Media\Exceptions\Collections;

use Exception;

class ThumbsDoesNotExists extends Exception
{
    /**
     * @return ThumbsDoesNotExists
     */
    public static function thumbsConversionNotFound(): ThumbsDoesNotExists
    {
        return new static(trans('brackets/media::media.exceptions.thumbs_does_not_exists'));
    }
}
