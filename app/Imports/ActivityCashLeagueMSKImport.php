<?php

namespace App\Imports;

use App\Models\ActivityCashLeagueDataMSK;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ActivityCashLeagueMSKImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public int $edition_id = 0;
    public int $activity_id = 0;

    public function collection(Collection $rows)
    {
        $rowsValid = 0;
        $rowsInvalid = 0;
        $rowsTotal = 0;
        $this->data = new \stdClass();


        ActivityCashLeagueDataMSK::query()->delete();
        foreach ($rows as $row) {
            try {
                if ($row["nepu"]) {
                    $activityRow = ActivityCashLeagueDataMSK::firstOrCreate(['nepu' => $row['nepu'], 'activity_id' => $this->activity_id, 'edition_id' => $this->edition_id]);
                    $activityRow->activity_id = $this->activity_id;
                    $activityRow->edition_id = $this->edition_id;
                    $activityRow->nepu = $row['nepu'];
                    $activityRow->njs = $row['njs'];
                    $activityRow->uczestnik = $row['uczestnik'];
                    $activityRow->stanowisko = $row['stanowisko'];
                    $activityRow->k1 = $row['k1'];
                    $activityRow->k2 = $row['k2'];
                    $activityRow->pkt = $row['pkt'];
                    $activityRow->miejsce = $row['miejsce'];
                    $activityRow->umowa = $row['umowa'];
                    $activityRow->save();
                } else {
                    $rowsInvalid++;
                }
            } catch (Exception $e) {
                $rowsInvalid++;
            }
            $rowsTotal++;
        }
        $this->data->rowsValid = $rowsValid;
        $this->data->rowsInvalid = $rowsInvalid;
        $this->data->rowsTotal = $rowsTotal;
    }
}
