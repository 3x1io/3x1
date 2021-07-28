<?php

namespace App\Exports;

use App\Models\Block;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BlocksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Block::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.block.columns.id'),
            trans('admin.block.columns.key'),
            trans('admin.block.columns.html'),
        ];
    }

    /**
     * @param Block $block
     * @return array
     *
     */
    public function map($block): array
    {
        return [
            $block->id,
            $block->key,
            $block->html,
        ];
    }
}
