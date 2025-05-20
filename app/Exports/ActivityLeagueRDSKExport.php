<?php

namespace App\Exports;

use App\Models\ActivityLeagueRDSKData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLeagueRDSKExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLeagueRDSKData::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'miejsce',
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
