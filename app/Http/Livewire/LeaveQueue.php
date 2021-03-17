<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use App\Models\LeaveTake;
use Livewire\Component;
use App\Traits\SearchTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Staff;
use App\Models\User;
use DB;

class LeaveQueue extends Component
{
    use WithPagination;
    use SearchTrait;
    public $filter = null;
    public $search = null;
    public $pagination = null;
    public $sortBy = null;

    protected $rules = [
        'filter' => '',
        'search' => '',
        'pagination' => '',
        'sortBy' => '',
    ];

    public function render()
    {
        $query = Leave::query();
        $query = $query->with('approvers.staff', 'raiser');
        if ($this->filter) {
            if ($this->filter == "approved") {
                $query->where('hr_finalized',1);
            }  elseif ($this->filter == "unapproved") {
                $query->where('finalized', 1)->whereNull('hr_finalized');
            }  else {
                $query->where('finalized', 1)->where('hr_finalized',null);
            }
        }else{
            $query->where('finalized', 1)->where('hr_finalized',null);
        }
        if ($this->sortBy) {
            $query->orderBy($this->sortBy);
        } else {
            $query->orderBy('created_at', 'DESC');
        }
        if ($this->search) {
            $query->search($this->search, []);
        }

        if ($this->pagination) {
            $leaves = $query->paginate($this->pagination);;
        } else {
            $leaves = $query->paginate(10);
        }


        return view('livewire.leave-queue')->with(compact('leaves'));
    }

    public function approveLeave($id, $days)
    {
        $leave = Leave::find($id);

        $leave->update(array(
            'amendedDays' => $days,
            'hr_finalized' => 1
        ));
        LeaveTake::create(array(
            'leave_id' => $id,
            'days' => $days
        ));
        $staff =  Staff::find($leave->staff_id);
        $days = $staff->leave_days - $days;
        $staff->update(array(
            'leave_days' => $days
        ));
        $user = User::where('pno',$staff->pno)->first();
        $user->notifications->where('data.leave_id', $id)->where('notifiable_id', $user->id)->markAsRead();
    }
}
