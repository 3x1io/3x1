<?php

namespace Brackets\Media\Exceptions\FileCannotBeAdded;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class TooManyFiles extends FileCannotBeAdded
{
    /**
     * @param int|null $maxFileCount
     * @param string|null $collectionName
     * @return TooManyFiles
     */
    public static function create(int $maxFileCount = null, string $collectionName = null): TooManyFiles
    {
        return new static(trans('brackets/media::media.exceptions.too_many_files',
            ['collectionName' => $collectionName, 'maxFileCount' => $maxFileCount]));
    }
}
