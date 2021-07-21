<?php

namespace App\Exports;

use App\Models\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AreasExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Area::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.area.columns.city_id'),
            trans('admin.area.columns.id'),
            trans('admin.area.columns.lang'),
            trans('admin.area.columns.lat'),
            trans('admin.area.columns.name'),
        ];
    }

    /**
     * @param Area $area
     * @return array
     *
     */
    public function map($area): array
    {
        return [
            $area->city_id,
            $area->id,
            $area->lang,
            $area->lat,
            $area->name,
        ];
    }
}
