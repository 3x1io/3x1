<?php

namespace Brackets\Media\HasMedia;

use Brackets\Media\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Brackets\Media\Exceptions\FileCannotBeAdded\TooManyFiles;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

/**
 * @property-read boolean $autoProcessMedia
 */
trait ProcessMediaTrait
{
    /**
     * Attaches and/or detaches all defined media collection to the model according to the $media
     *
     * This method process data from structure:
     *
     * $request = [
     *      ...
     *      'collectionName' => [
     *          [
     *              'id' => null,
     *              'collection_name' => 'collectionName',
     *              'path' => 'test.pdf',
     *              'action' => 'add',
     *              'meta_data' => [
     *                  'name' => 'test',
     *                  'width' => 200,
     *                  'height' => 200,
     *              ],
     *          ],
     *      ],
     *      ...
     * ];
     *
     * Firstly it validates input for max files count for mediaCollection, ile mimetype and file size, amd if the
     * validation passes it will add/change/delete media object to model
     *
     * @param Collection $inputMedia
     */
    public function processMedia(Collection $inputMedia): void
    {
//        Don't we want to use maybe some class to represent the data structure?
//        Maybe what we want is a MediumOperation class, which holds {collection name, operation (detach, attach, replace), metadata, filepath)} what do you think?

        //First validate input
        $this->getMediaCollections()->each(function ($mediaCollection) use ($inputMedia) {
            $this->validate(collect($inputMedia->get($mediaCollection->getName())), $mediaCollection);
        });

        //Then process each media
        $this->getMediaCollections()->each(function ($mediaCollection) use ($inputMedia) {
            collect($inputMedia->get($mediaCollection->getName()))->each(function ($inputMedium) use (
                $mediaCollection
            ) {
                $this->processMedium($inputMedium, $mediaCollection);
            });
        });
    }

    /**
     * Process single file metadata add/edit/delete to media library
     *
     * @param $inputMedium
     * @param $mediaCollection
     * @throws FileCannotBeAdded
     */
    public function processMedium(array $inputMedium, MediaCollection $mediaCollection): void
    {
        if (isset($inputMedium['id']) && $inputMedium['id']) {
            if ($medium = app(MediaModel::class)->find($inputMedium['id'])) {
                if (isset($inputMedium['action']) && $inputMedium['action'] === 'delete') {
                    $medium->delete();
                } else {
                    $medium->custom_properties = $inputMedium['meta_data'];
                    $medium->save();
                }
            }
        } elseif (isset($inputMedium['action']) && $inputMedium['action'] === 'add') {
            $mediumFileFullPath = Storage::disk('uploads')->getDriver()->getAdapter()->applyPathPrefix($inputMedium['path']);

            $this->addMedia($mediumFileFullPath)
                ->withCustomProperties($inputMedium['meta_data'])
                ->toMediaCollection($mediaCollection->getName(), $mediaCollection->getDisk());
        }
    }

    /**
     * Validae input data for media
     *
     * @param Collection $inputMediaForMediaCollection
     * @param MediaCollection $mediaCollection
     * @throws FileCannotBeAdded
     */
    public function validate(Collection $inputMediaForMediaCollection, MediaCollection $mediaCollection): void
    {
        $this->validateCollectionMediaCount($inputMediaForMediaCollection, $mediaCollection);
        $inputMediaForMediaCollection->each(function ($inputMedium) use ($mediaCollection) {
            if ($inputMedium['action'] === 'add') {
                $mediumFileFullPath = Storage::disk('uploads')->getDriver()->getAdapter()->applyPathPrefix($inputMedium['path']);
                $this->validateTypeOfFile($mediumFileFullPath, $mediaCollection);
                $this->validateSize($mediumFileFullPath, $mediaCollection);
            }
        });
    }

    /**
     * Validate uploaded files count in collection
     *
     * @param Collection $inputMediaForMediaCollection
     * @param MediaCollection $mediaCollection
     * @throws TooManyFiles
     */
    public function validateCollectionMediaCount(
        Collection $inputMediaForMediaCollection,
        MediaCollection $mediaCollection
    ): void {
        if ($mediaCollection->getMaxNumberOfFiles()) {
            $alreadyUploadedMediaCount = $this->getMedia($mediaCollection->getName())->count();
            $forAddMediaCount = $inputMediaForMediaCollection->filter(static function ($medium) {
                return $medium['action'] === 'add';
            })->count();
            $forDeleteMediaCount = $inputMediaForMediaCollection->filter(static function ($medium) {
                return $medium['action'] === 'delete' ? 1 : 0;
            })->count();
            $afterUploadCount = ($forAddMediaCount + $alreadyUploadedMediaCount - $forDeleteMediaCount);

            if ($afterUploadCount > $mediaCollection->getMaxNumberOfFiles()) {
                throw TooManyFiles::create($mediaCollection->getMaxNumberOfFiles(), $mediaCollection->getName());
            }
        }
    }

    /**
     * Validate uploaded file mime type
     *
     * @param string $mediumFileFullPath
     * @param MediaCollection $mediaCollection
     */
    public function validateTypeOfFile(string $mediumFileFullPath, MediaCollection $mediaCollection): void
    {
        if ($mediaCollection->getAcceptedFileTypes()) {
            $this->guardAgainstInvalidMimeType($mediumFileFullPath, $mediaCollection->getAcceptedFileTypes());
        }
    }

    /**
     * Validate uploaded file size
     *
     * @param string $mediumFileFullPath
     * @param MediaCollection $mediaCollection
     * @throws FileIsTooBig
     */
    public function validateSize(string $mediumFileFullPath, MediaCollection $mediaCollection): void
    {
        if ($mediaCollection->getMaxFileSize()) {
            $this->guardAgainstFileSizeLimit(
                $mediumFileFullPath,
                $mediaCollection->getMaxFileSize(),
                $mediaCollection->getName()
            );
        }
    }

    /**
     * maybe this could be PR to spatie/laravel-medialibrary
     *
     * @param string $filePath
     * @param float $maxFileSize
     * @param string $name
     * @throws FileIsTooBig
     */
    protected function guardAgainstFileSizeLimit(string $filePath, float $maxFileSize, string $name): void
    {
        $validation = Validator::make(
            ['file' => new File($filePath)],
            ['file' => 'max:' . round($maxFileSize / 1024)]
        );

        if ($validation->fails()) {
            throw FileIsTooBig::create($filePath, $maxFileSize, $name);
        }
    }
}
