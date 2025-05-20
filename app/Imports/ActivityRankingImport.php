<?php

namespace App\Imports;

use App\Models\ActivityCashLeagueDataDSK;
use App\Models\ActivityRankingData;
use App\Models\ActivitySaleContestData;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ActivityRankingImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public $data;
    public int $edition_id = 0;
    public int $activity_id = 0;

    public function collection(Collection $rows)
    {
        $rowsValid = 0;
        $rowsInvalid = 0;
        $rowsTotal = 0;
        $this->data = new \stdClass();
        ActivityRankingData::where('activity_id',3)
            ->where('edition_id',$this->edition_id)
            ->delete();
        foreach ($rows as $row) {
            try {
                if ($row["nepu"]) {
                    $activityRow = ActivityRankingData::where('nepu',$row['nepu'])
                    ->where('activity_id',3)
                    ->where('edition_id',$this->edition_id)
                    ->first();
                    if (!$activityRow)
                    {
                        $activityRow = new ActivityRankingData();
                    }
                    $activityRow->activity_id = 3;
                    $activityRow->edition_id = $this->edition_id;
                    $activityRow->nepu = $row['nepu'];
                    $activityRow->njs = $row['njs'];
                    $activityRow->uczestnik = $row['uczestnik'];
                    $activityRow->stanowisko = $row['stanowisko'];
                    $activityRow->data = $row['data'];
                    $activityRow->wartosc = $row['wartosc'];
                    $activityRow->punkty = $row['punkty'];
                    $activityRow->save();
                    $rowsValid++;
                }
                else {
                    $rowsInvalid++;
                }
            }
            catch (Exception $e)
            {
                $rowsInvalid++;
            }
            $rowsTotal++;
        }
        $this->data->rowsValid = $rowsValid;
        $this->data->rowsInvalid = $rowsInvalid;
        $this->data->rowsTotal = $rowsTotal;
    }
}
