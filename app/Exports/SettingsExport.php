<?php

namespace App\Exports;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SettingsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Setting::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.setting.columns.group'),
            trans('admin.setting.columns.id'),
            trans('admin.setting.columns.key'),
            trans('admin.setting.columns.value'),
        ];
    }

    /**
     * @param Setting $setting
     * @return array
     *
     */
    public function map($setting): array
    {
        return [
            $setting->group,
            $setting->id,
            $setting->key,
            $setting->value,
        ];
    }
}
