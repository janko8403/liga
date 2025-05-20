<?php

namespace App\Exports;

use App\Models\ActivityLeagueDSKData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLeagueDSKExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLeagueDSKData::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'miejsce',
            'njs_dsk',
            'dsk',
            'mws',
            'region',
            'rdsk',
            'mws_reg',
            'k1',
            'k2',
            'k3',
            'k4',
            'k5',
            'k6',
            'suma'
        ];
        //return array_keys($this->collection()->first()->toArray());
    }
}
