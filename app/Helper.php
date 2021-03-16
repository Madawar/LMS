<?php


namespace App;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Builder;

class Helper
{
    public static function calculateDays($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $period = CarbonPeriod::create($startDate, $endDate);
        $sundays = array();
        $saturdays = array();
        $holidays = array();
        $weekDays = array();
        foreach ($period as $key => $date) {
            if ($date->isSunday()) {
                array_push($sundays, $date->format('Y-m-d'));
            }
            if ($date->isWeekday()) {
                array_push($weekDays, $date->format('Y-m-d'));
            }
            if ($date->isSaturday()) {
                array_push($saturdays, $date->format('Y-m-d'));
            }
        }

        $calculation = count($weekDays) + count($saturdays);

        return array('sundays' => $sundays, 'saturdays' => $saturdays, 'weekdays' => $weekDays, 'holidays' => $holidays, 'calculation' => $calculation);
    }

    public static function unapprovedLeaves($id)
    {
        return $leave_has_unnaproved = Leave::whereHas('approvers', function (Builder $query) {
            $query->where('approved', 0)->where('level', '!=', 'Department Manager');
        })->where('id', $id)->get();
    }
    public static function approvedLeaves($id)
    {
        return $leave_has_unnaproved = Leave::whereHas('approvers', function (Builder $query) {
            $query->where('approved', 0);
        })->where('id', $id)->get();
    }

    public static function approvedByRelievers($id)
    {
        $leaves = Helper::unapprovedLeaves($id);
        if ($leaves->count() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function unapprovedByManager($id)
    {
        return Leave::whereHas('approvers', function (Builder $query) {
            $query->where('approved', 0)->where('level', '=', 'Department Manager');
        })->with(['approvers' => function ($query) {
            $query->where('approved', 0);
            $query->where('level', '=', 'Department Manager');
            $query->with('staff.user');
            $query->first();
        }])->where('id', $id)->get();
    }
}
