<?php

namespace App\Exports;

use App\Models\Language;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LanguagesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Language::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.language.columns.arabic'),
            trans('admin.language.columns.id'),
            trans('admin.language.columns.iso'),
            trans('admin.language.columns.name'),
        ];
    }

    /**
     * @param Language $language
     * @return array
     *
     */
    public function map($language): array
    {
        return [
            $language->arabic,
            $language->id,
            $language->iso,
            $language->name,
        ];
    }
}
