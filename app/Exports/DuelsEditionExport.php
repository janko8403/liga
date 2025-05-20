<?php

namespace App\Exports;

use App\Models\DuelData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuelsEditionExport implements FromCollection,WithHeadings
{

    public int $edition_id;

    function __construct($edition_id) {
        $this->edition_id = $edition_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DuelData::select($this->headings())->where('edition_id','=',$this->edition_id)->get();
    }

    public function headings(): array
    {
        return [
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
}
