<?php

namespace App\Exports;

use App\Models\ActivityLeagueMWSData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLeagueMWSExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLeagueMWSData::select($this->headings())->orderBy('miejsce','asc')->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'miejsce',
            'mws',
            'njs_dsk',
            'dsk',
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

    public function data()
    {
        return ActivityLeagueMWSData::all();
    }
}
