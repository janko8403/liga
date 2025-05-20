<?php

namespace App\Exports;

use App\Models\ActivityLeagueSWSData;
use App\Models\ActivitySaleContestData;
use App\Models\ContestData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityContestExport implements FromCollection,WithHeadings
{


    public int $edition_id;

    function __construct($contest_id) {
        $this->contest_id = $contest_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivitySaleContestData::select($this->headings())->where('edition_id','=',$this->contest_id)->get();
    }

    public function headings(): array
    {
        return [
            'nepu',
            'njs',
            'uczestnik',
            'stanowisko',
            'data',
            'wartosc',
            'dodatkowe',
            'nagroda'
        ];
        //return array_keys($this->collection()->first()->toArray());
    }
}
