<?php

namespace Brackets\Media\Test;

use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestModel extends Model implements HasMedia
{
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    public $timestamps = false;
    protected $table = 'test_models';
    protected $guarded = [];

    /**
     * Media collections
     *
     */
    public function registerMediaCollections(): void
    {
    }

    /**
     * Register the conversions that should be performed.
     *
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
    }
}
