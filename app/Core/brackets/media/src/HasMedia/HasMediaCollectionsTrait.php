<?php

namespace Brackets\Media\HasMedia;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\InteractsWithMedia as ParentHasMediaTrait;

trait HasMediaCollectionsTrait
{
    use ParentHasMediaTrait;

    /**
     * Register new Media Collection
     *
     * Adds new collection to model and set its name.
     *
     * @param $name
     *
     * @return MediaCollection
     */
    public function addMediaCollection($name): MediaCollection
    {
        $mediaCollection = MediaCollection::create($name);

        $this->mediaCollections[] = $mediaCollection;

        return $mediaCollection;
    }

    /**
     * Returns a collection of Media Collections
     *
     * @return Collection
     */
    public function getMediaCollections(): Collection
    {
        $this->registerMediaCollections();

        return collect($this->mediaCollections)->keyBy('name');
    }

    /**
     * Returns a Media Collection according to the name
     *
     * If Media Collection was not registered on this model, null is returned
     *
     * @param $name
     *
     * @return MediaCollection|null
     */
    public function getMediaCollection($name): ?MediaCollection
    {
        return $this->getMediaCollections()->get($name);
    }
}
