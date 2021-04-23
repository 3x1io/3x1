<?php

namespace Brackets\AdminTranslations\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TranslationsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // we don't want to store anything yet, so we leave this method empty
    }
}
