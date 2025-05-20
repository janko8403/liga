<?php

namespace App\Imports;

use App\Models\DuelData;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class DuelsEditionImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public int $edition_id = 0;
    public int $activity_id = 0;

    public function collection(Collection $rows)
    {
        $rowsValid = 0;
        $rowsTotal = 0;
        $rowsInvalid = 0;

        $this->data = new \stdClass();

        DuelData::where('activity_id','=',$this->activity_id)
            ->where('edition_id','=',$this->edition_id)
            ->delete();

        foreach ($rows as $row) {
            try {
                $dataRow = DuelData::firstOrCreate([
                    'nepu_msk' => $row['nepu_msk'],
                    'nepu_dsk' => $row['nepu_dsk'],
                    'activity_id' => $this->activity_id,
                    'edition_id' => $this->edition_id]
                );
                $dataRow->activity_id = $this->activity_id;
                $dataRow->edition_id = $this->edition_id;
                $dataRow->nepu_dsk = $row['nepu_dsk'];
                $dataRow->njs_dsk = $row['njs_dsk'];
                $dataRow->dsk = $row['dsk'];
                $dataRow->nepu_msk = $row['nepu_msk'];
                $dataRow->njs_msk = $row['njs_msk'];
                $dataRow->msk = $row['msk'];
                $dataRow->data = $row['data'];
                $dataRow->wynik_msk = $row['wynik_msk'];
                $dataRow->save();
                $rowsValid++;
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
