<?php

namespace App\Imports;

use App\Models\ActivityLeagueDSKData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ActivityLeagueDSKImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public int $edition_id = 0;
    public int $activity_id = 0;

    public function collection(Collection $rows)
    {
        $rowsValid = 0;
        $rowsInvalid = 0;
        $rowsTotal = 0;
        $this->data = new \stdClass();

        ActivityLeagueDSKData::query()->delete();
        foreach ($rows as $row) {
            try {
                if ($row["nepu"]) {
                    $activityRow = ActivityLeagueDSKData::firstOrCreate(['nepu' => $row['nepu'], 'activity_id' => $this->activity_id, 'edition_id' => $this->edition_id]);
                    $activityRow->activity_id = $this->activity_id;
                    $activityRow->edition_id = $this->edition_id;
                    $activityRow->nepu = $row['nepu'];
                    $activityRow->miejsce = $row['miejsce'];
                    $activityRow->njs_dsk = $row['njs_dsk'];
                    $activityRow->dsk = $row['dsk'];
                    $activityRow->mws = $row['mws'];
                    $activityRow->mws_reg = $row['mws_reg'];
                    $activityRow->region = $row['region'];
                    $activityRow->rdsk = $row['rdsk'];
                    $activityRow->k1 = $row['k1'];
                    $activityRow->k2 = $row['k2'];
                    $activityRow->k3 = $row['k3'];
                    $activityRow->k4 = $row['k4'];
                    $activityRow->k5 = $row['k5'];
                    $activityRow->k6 = $row['k6'];
                    $activityRow->suma = $row['suma'];
                    $activityRow->save();
                    $rowsValid++;
                } else {
                    $rowsInvalid++;
                }
            } catch (Exception $e)
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
