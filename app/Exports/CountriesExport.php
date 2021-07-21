<?php

namespace App\Exports;

use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountriesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Country::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.country.columns.id'),
            trans('admin.country.columns.name'),
            trans('admin.country.columns.code'),
            trans('admin.country.columns.phone'),
            trans('admin.country.columns.lat'),
            trans('admin.country.columns.lang'),
        ];
    }

    /**
     * @param Country $country
     * @return array
     *
     */
    public function map($country): array
    {
        return [
            $country->id,
            $country->name,
            $country->code,
            $country->phone,
            $country->lat,
            $country->lang,
        ];
    }
}
