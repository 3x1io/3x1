<?php

namespace Brackets\Media\Test;

use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestModelWithCollectionsDisabledAutoProcess extends TestModel
{
    /**
     * Media collections
     *
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->maxNumberOfFiles(20)
            ->maxFilesize(2 * 1024 * 1024)
            ->accepts('image/*');

        $this->addMediaCollection('documents')
            ->private()
            ->canView('vop.view')
            ->canUpload('vop.upload')
            ->maxNumberOfFiles(20)
            ->maxFilesize(2 * 1024 * 1024)
            ->accepts('application/pdf', 'application/msword');

        $this->addMediaCollection('zip')
            ->private()
            ->canView('vop.view')
            ->canUpload('vop.upload')
            ->maxNumberOfFiles(20)
            ->maxFilesize(2 * 1024 * 1024)
            ->accepts('application/octet-stream');
    }

    /**
     * Register the conversions that should be performed.
     *
     * @param null|Media $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();

        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('gallery');
    }
}
