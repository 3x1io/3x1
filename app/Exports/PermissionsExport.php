<?php

namespace App\Exports;

use App\Models\Permission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermissionsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Permission::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.permission.columns.guard_name'),
            trans('admin.permission.columns.id'),
            trans('admin.permission.columns.name'),
        ];
    }

    /**
     * @param Permission $permission
     * @return array
     *
     */
    public function map($permission): array
    {
        return [
            $permission->guard_name,
            $permission->id,
            $permission->name,
        ];
    }
}
