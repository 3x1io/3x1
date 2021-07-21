<?php

namespace App\Exports;

use App\Models\City;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitiesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return City::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.city.columns.country_id'),
            trans('admin.city.columns.id'),
            trans('admin.city.columns.lang'),
            trans('admin.city.columns.lat'),
            trans('admin.city.columns.name'),
            trans('admin.city.columns.price'),
            trans('admin.city.columns.shipping'),
        ];
    }

    /**
     * @param City $city
     * @return array
     *
     */
    public function map($city): array
    {
        return [
            $city->country_id,
            $city->id,
            $city->lang,
            $city->lat,
            $city->name,
            $city->price,
            $city->shipping,
        ];
    }
}
