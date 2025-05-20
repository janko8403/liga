<?php

namespace App\Exports;

use App\Models\ActivityLeagueSWSData;
use App\Models\ActivityRankingData;
use App\Models\ContestData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityRankingExport implements FromCollection,WithHeadings
{
    public int $edition_id;

    function __construct($task_id) {
        $this->task_id = $task_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityRankingData::select($this->headings())->where('activity_id','=',$this->task_id)->get();
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
            'punkty',
        ];
    }
}
