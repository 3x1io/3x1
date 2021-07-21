<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RolesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Role::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.role.columns.guard_name'),
            trans('admin.role.columns.id'),
            trans('admin.role.columns.name'),
        ];
    }

    /**
     * @param Role $role
     * @return array
     *
     */
    public function map($role): array
    {
        return [
            $role->guard_name,
            $role->id,
            $role->name,
        ];
    }
}
