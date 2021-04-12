<?php

namespace App\Imports;

use App\Models\Staff;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class StaffImport implements ToModel, WithProgressBar
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[2] != '') {
            $date = Carbon::parse($row[2]);
        } else {
            $date = Carbon::today();
        }
        if ($row[3] == "") {
            $days = 0;
        } else {
            $days = $row[3];
        }
        return new Staff([
            'staff' => $row[0],
            'pno' => $row[1],
            'dateOfEmployment' => $date,
            'leaveIncrement' => '1.75',
            'leave_days' => $days
        ]);
    }
}
