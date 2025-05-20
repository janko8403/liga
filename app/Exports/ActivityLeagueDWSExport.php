<?php

namespace App\Exports;

use App\Models\ActivityLeagueDWSData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLeagueDWSExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLeagueDWSData::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'njs_dws',
            'dws',
            'njs_dsk',
            'dsk',
            'region',
            'miejsce',
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
