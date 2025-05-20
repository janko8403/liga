<?php

namespace App\Exports;

use App\Models\DuelData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuelsEditionsExport implements FromCollection,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DuelData::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'edition_id',
            'nepu_dsk',
            'njs_dsk',
            'dsk',
            'nepu_msk',
            'njs_msk',
            'msk',
            'data',
            'wynik_msk',
        ];
    }

    public function data()
    {
        return DuelData::all();
    }
}
