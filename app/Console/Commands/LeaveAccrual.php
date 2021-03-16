<?php

namespace App\Console\Commands;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LeaveAccrual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:accrue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leave Accrual';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $staff = Staff::all();
        foreach ($staff as $s) {
            $today = Carbon::now();
            if ($s->dateOfEmployment->day == $today->day) {
                Staff::find($s->id)->update(array(
                    'leave_days' => $s->leave_days + $s->leaveIncrements
                ));
                \App\Models\LeaveAccrual::create(array(
                    'staff_id' => $s->id,
                    'month' => Carbon::now()->monthName,
                    'previous_value' => $s->leave_days,
                    'increment_value' => $s->leaveIncrements,
                    'new_value' => $s->leaveIncrements + $s->leave_days
                ));
            }
        }
    }
}
