<?php

namespace App\Exports;

use App\Models\Medium;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MediaExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Medium::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.medium.columns.collection_name'),
            trans('admin.medium.columns.conversions_disk'),
            trans('admin.medium.columns.custom_properties'),
            trans('admin.medium.columns.disk'),
            trans('admin.medium.columns.file_name'),
            trans('admin.medium.columns.generated_conversions'),
            trans('admin.medium.columns.id'),
            trans('admin.medium.columns.manipulations'),
            trans('admin.medium.columns.mime_type'),
            trans('admin.medium.columns.model_id'),
            trans('admin.medium.columns.model_type'),
            trans('admin.medium.columns.name'),
            trans('admin.medium.columns.order_column'),
            trans('admin.medium.columns.responsive_images'),
            trans('admin.medium.columns.size'),
            trans('admin.medium.columns.uuid'),
        ];
    }

    /**
     * @param Medium $medium
     * @return array
     *
     */
    public function map($medium): array
    {
        return [
            $medium->collection_name,
            $medium->conversions_disk,
            $medium->custom_properties,
            $medium->disk,
            $medium->file_name,
            $medium->generated_conversions,
            $medium->id,
            $medium->manipulations,
            $medium->mime_type,
            $medium->model_id,
            $medium->model_type,
            $medium->name,
            $medium->order_column,
            $medium->responsive_images,
            $medium->size,
            $medium->uuid,
        ];
    }
}
