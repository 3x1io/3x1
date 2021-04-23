<?php

namespace Brackets\Media\UrlGenerator;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator as SpatieUrlGenerator;

class LocalUrlGenerator extends SpatieUrlGenerator
{
    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->media->disk === 'media_private') {
            $url = $this->getPathRelativeToRoot();

            return route('brackets/media::view', [], false) . '?path=' . $this->makeCompatibleForNonUnixHosts($url);
        } else {
            return parent::getUrl();
        }
    }

    protected function makeCompatibleForNonUnixHosts(string $url): string
    {
        if (DIRECTORY_SEPARATOR != '/') {
            $url = str_replace(DIRECTORY_SEPARATOR, '/', $url);
        }

        return $url;
    }
}
