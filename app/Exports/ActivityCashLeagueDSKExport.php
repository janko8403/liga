<?php

namespace App\Exports;

use App\Models\ActivityCashLeagueDataDSK;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityCashLeagueDSKExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityCashLeagueDataDSK::select($this->headings())->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'njs',
            'uczestnik',
            'stanowisko',
            'k1',
            'pkt',
            'miejsce',
            'umowa',
        ];
        //return array_keys($this->collection()->first()->toArray());
    }
}
