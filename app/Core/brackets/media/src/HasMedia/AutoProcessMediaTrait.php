<?php

namespace Brackets\Media\HasMedia;

trait AutoProcessMediaTrait
{
    /**
     * Setup to auto process during saving
     */
    public static function bootHasMediaCollectionsTrait(): void
    {
        static::saving(static function ($model) {
            /** @var self $model */
            $model->processMedia(collect(request()->only($model->getMediaCollections()->map->getName()->toArray())));
        });
    }
}
