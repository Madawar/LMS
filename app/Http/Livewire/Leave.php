<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Carbon\CarbonPeriod;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Approval;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRaised;
use App\Models\Holiday;

class Leave extends Component
{
    public $date;
    public $leaveType;
    public $startDate;
    public $endDate;
    public $calculation;
    public $relievers;
    public $relievers_list;
    public $selected;
    public $relievers_display;
    public $leaveid;
    public $max_relievers;

    protected $listeners = ['selectChanged' => 'getRelievers'];
    protected $rules = [
        'date' => 'required',
        'leaveType' => 'required',
        'calculation' => '',
        'relievers' => '',
        'relievers_list' => '',
        'selected' => '',
        'relievers_display' => '',
        'leaveid' => '',
        'max_relievers' => ''
    ];
    public function mount($leaveid = null)
    {

        if ($leaveid) {

            $leave = \App\Models\Leave::with('raiser', 'approvers')->find($leaveid);
            $selected = Staff::whereIn('id', $leave->approvers->pluck('staff_id'))->pluck('id');
            $this->selected = $selected;
            $this->relievers = $selected;

            $this->startDate = $leave->startDate;
            $this->endDate = $leave->endDate;
            $this->leaveType = $leave->leaveType;
            $this->calculation = $this->calculateLeaveDays($this->startDate, $this->endDate);

            $this->getRelieversWithoutManager($leave->approvers);
        } else {
            $this->calculation = null;
            $this->selected = [];
            $this->relievers_display = [];
        }
        $staff = Staff::where('pno', Auth::user()->pno)->first();
        $this->max_relievers = (int) Department::find($staff->department)->number_of_relievers;
        $user = Staff::where('pno', Auth::user()->pno)->firstOrFail();
        $this->relievers_list = Staff::with('department.manager')->where('department', $user->department)->where('id', '!=', Auth::user()->id)->pluck('staff', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.leave');
    }

    public function calculateDays()
    {
        if ($this->date != "") {
            $this->endDate =  Carbon::createFromFormat('Y-m-d', trim(Str::after($this->date, 'to')));
            $this->startDate = Carbon::createFromFormat('Y-m-d', trim(Str::before($this->date, 'to')));
            $this->calculation =  $this->calculateLeaveDays($this->startDate, $this->endDate);
        }
    }

    public  function calculateLeaveDays($startDate, $endDate)
    {
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
            $isHoliday = Holiday::where('date', $date->format('Y-m-d'))->first();
            if ($isHoliday) {
                array_push($holidays, $date->format('Y-m-d'));
            }
            if ($date->isSaturday()) {
                array_push($saturdays, $date->format('Y-m-d'));
            }
        }

        $calculation = count($weekDays) + count($saturdays);

        return array('sundays' => $sundays, 'saturdays' => $saturdays, 'weekdays' => $weekDays, 'holidays' => $holidays, 'calculation' => $calculation);
    }

    public function getRelievers()
    {
        $this->relievers_display = null;
        foreach ($this->relievers as $user) {
            $this->relievers_display[] = array('staff_id' => Staff::find($user)->id, 'staff' => Staff::find($user)->staff, 'function' => 'Reliever');
        }
        $this->getDepartmentManagers();
    }

    public function getRelieversWithoutManager($approvers)
    {
        $this->relievers_display = null;
        foreach ($approvers as $user) {

            $this->relievers_display[] = array('staff_id' => $user->staff_id, 'staff' => Staff::find($user->staff_id)->staff, 'function' => $user->level);
        }
    }

    public function getDepartmentManagers()
    {
        $staff = Staff::with('department.manager')->where('pno', '=', Auth::user()->pno)->first();;
        $department = Department::with('manager')->find($staff->department);

        if ($department->supervisors) {
            $supervisors = Staff::whereIn('id', json_decode($department->supervisors))->get();
            //TODO Check SUpervisors Logic
            foreach ($supervisors as $supervisor) {
                $this->relievers_display[] = array('staff_id' => $supervisor->id, 'staff' => $supervisor->staff, 'function' => 'Supervisor');
            }
        }
        $this->relievers_display[] = array('staff_id' => $department->manager->id, 'staff' => $department->manager->staff, 'function' => 'Department Manager');
    }

    public function saveLeave()
    {
        DB::transaction(function () {
            $leave = \App\Models\Leave::create(array(
                'staff_id' => Auth::user()->id,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'leaveType' => $this->leaveType,
                'calculatedDays' => $this->calculation['calculation'],
                'amendedDays' => $this->calculation['calculation'],
            ));
            $this->leaveid = $leave->id;
            $order = -1;
            foreach ($this->relievers_display as $approval) {
                $order = $order + 1;
                Approval::create(array(
                    'leave_id' => $leave->id,
                    'staff_id' => $approval['staff_id'],
                    'level' => $approval['function'],
                    'order' => $order
                ));
            }
            $this->notifyStaff($leave);
        });

        $this->message('Leave Application Recorded');
    }
    public function updateLeave()
    {
        DB::transaction(function () {
            $leave = \App\Models\Leave::findOrFail($this->leaveid);
            $leave->update(array(
                'staff_id' => Auth::user()->id,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'leaveType' => $this->leaveType,
                'calculatedDays' => $this->calculation['calculation'],
                'amendedDays' => $this->calculation['calculation'],
            ));
            //Delete Notifications and Approvals
            Approval::where('leave_id', $this->leaveid)->delete();
            DB::table('notifications')
                ->where('data->leave_id', $this->leaveid)
                ->delete();
            $order = -1;
            foreach ($this->relievers_display as $approval) {
                $order = $order + 1;
                Approval::create(array(
                    'leave_id' => $leave->id,
                    'staff_id' => $approval['staff_id'],
                    'level' => $approval['function'],
                    'order' => $order
                ));
            }
            $this->notifyStaff($leave);
        });
        $this->message('Leave Application Updated');
    }
    public function notifyStaff($leave)
    {
        $leave = \App\Models\Leave::with('raiser', 'approvers.staff.user')->findOrFail($leave->id);
        foreach ($leave->approvers->where('level', '!=', 'Department Manager') as $approver) {
            $notify_staff = $approver->staff->user;
            $notify_staff->notify(new \App\Notifications\LeaveRaised($leave, $approver));
            if ($approver->email != "") {
                Mail::to($approver->email)->send(new LeaveRaised($leave, $approver));
            }
        }
        return $leave;
    }

    public function message($message)
    {
        session()->flash('message', $message);
        $this->emit('message', $message);
    }
}
