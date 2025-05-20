<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class UserImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public int $edition_id = 0;
    public int $activity_id = 0;

    public function collection(Collection $rows)
    {
        $rowsValid = 0;
        $rowsTotal = 0;

        foreach ($rows as $row) {
            try {
                $addInitialValues = 0;
                $dataRow = User::where('nepu',$row["nepu"])->first();
                if (!$dataRow && $row["nepu"]!="") {
                    $addInitialValues = 1;
                    $dataRow = new User();
                    $dataRow->verification_token = bin2hex(random_bytes(25));
                }

                $dataRow->name = $row['name'];
                $dataRow->lastname = $row['lastname'];
                $dataRow->region = $row['region'];
                $dataRow->njs = $row['njs'];
                $dataRow->nepu = $row['nepu'];
                $dataRow->position = $row['position'];
                $dataRow->phone = $row['phone'];
                $dataRow->network = $row['network'];
                $dataRow->email = $row['email'];
                $dataRow->save();

                if ($addInitialValues === 1) {
                    $dataRow->email_verified_at = $row['data'];
                    $dataRow->is_validated = 0;
                    $dataRow->last_verification_email = Carbon::now();
                    (new \App\Http\Controllers\Backend\UsersController)->sendVerificationEmail($dataRow);
                    $dataRow->save();
                }

                $rowsValid++;
            }
            catch (Exception $e)
            {
                return $row;
            }
            $rowsTotal++;
        }
        return($rowsValid."/".$rowsTotal);
    }
}
