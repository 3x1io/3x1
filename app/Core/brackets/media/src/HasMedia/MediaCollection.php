<?php

namespace Brackets\Media\HasMedia;

use Spatie\MediaLibrary\MediaCollections\MediaCollection as ParentMediaCollection;

class MediaCollection extends ParentMediaCollection
{
    /** @var bool */
    protected $isImage = false;
    
    /** @var int */
    protected $maxNumberOfFiles;
    
    /** @var float */
    protected $maxFileSize;
    
    /** @var array */
    protected $acceptedFileTypes;
    
    /** @var string */
    protected $viewPermission;
    
    /** @var string */
    protected $uploadPermission;

    /**
     * MediaCollection constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->diskName = config('media-collections.public_disk', 'media');
    }


    /**
     * Specify a disk where to store this collection
     *
     * @param $disk
     * @return $this
     * @deprecated deprecated since version 3.0, remove in version 4.0
     */
    public function disk($disk): self
    {
        $this->diskName = $disk;

        return $this;
    }

    /**
     * Alias to setting default private disk
     *
     * @return $this
     */
    public function private(): self
    {
        $this->diskName = config('media-collections.private_disk');

        return $this;
    }

    /**
     * Set the file count limit
     *
     * @param $maxNumberOfFiles
     *
     * @return $this
     */
    public function maxNumberOfFiles($maxNumberOfFiles): self
    {
        $this->maxNumberOfFiles = $maxNumberOfFiles;

        return $this;
    }

    /**
     * Set the file size limit
     *
     * @param $maxFileSize
     *
     * @return $this
     */
    public function maxFileSize($maxFileSize): self
    {
        $this->maxFileSize = $maxFileSize;

        return $this;
    }

    /**
     * Set the accepted file types (in MIME type format)
     *
     * @param array ...$acceptedFileTypes
     *
     * @return $this
     */
    public function accepts(...$acceptedFileTypes): self
    {
        $this->acceptedFileTypes = $acceptedFileTypes;
        if (collect($this->acceptedFileTypes)->count() > 0) {
            $this->isImage = collect($this->acceptedFileTypes)->reject(static function ($fileType) {
                return strpos($fileType, 'image') === 0;
            })->count() === 0;
        }

        return $this;
    }

    /**
     * Set the ability (Gate) which is required to view the medium
     *
     * In most cases you would want to call private() to use default private disk.
     *
     * Otherwise, you may use other private disk for your own. Just be sure, your file is not accessible
     *
     * @param $viewPermission
     *
     * @return $this
     */
    public function canView($viewPermission): self
    {
        $this->viewPermission = $viewPermission;

        return $this;
    }

    /**
     * Set the ability (Gate) which is required to upload & attach new files to the model
     *
     * @param $uploadPermission
     *
     * @return $this
     */
    public function canUpload($uploadPermission): self
    {
        $this->uploadPermission = $uploadPermission;

        return $this;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->isImage;
    }

    //FIXME: metoda disk by mohla mat druhy nepovinny paramater private, ktory len nastavi interny flag na true. Aby sme vedeli presnejsie ci ide o private alebo nie
    public function isPrivate(): bool
    {
        return $this->diskName === config('media-collections.private_disk');
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDisk(): ?string
    {
        return $this->diskName;
    }

    /**
     * @return int|null
     */
    public function getMaxNumberOfFiles(): ?int
    {
        return $this->maxNumberOfFiles;
    }

    /**
     * @return float|null
     */
    public function getMaxFileSize(): ?float
    {
        return $this->maxFileSize;
    }

    /**
     * @return array|null
     */
    public function getAcceptedFileTypes(): ?array
    {
        return $this->acceptedFileTypes;
    }

    /**
     * @return string|null
     */
    public function getViewPermission(): ?string
    {
        return $this->viewPermission;
    }

    /**
     * @return string|null
     */
    public function getUploadPermission(): ?string
    {
        return $this->uploadPermission;
    }
}
