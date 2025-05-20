<?php

namespace App\Exports;

use App\Models\ActivityCashLeagueDataMSK;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityCashLeagueMSKExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityCashLeagueDataMSK::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'njs',
            'uczestnik',
            'stanowisko',
            'k1',
            'k2',
            'pkt',
            'miejsce',
            'umowa',
        ];
        //return array_keys($this->collection()->first()->toArray());
    }
}
