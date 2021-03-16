<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Staff as ModelsStaff;
use App\Models\User;
use Livewire\Component;
use App\Traits\SearchTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithPagination;
    use SearchTrait;
    public $staff;
    public $pno;
    public $email;
    public $department;
    public $leave_days;
    public $dateOfEmployment;
    public $workingDays;
    public $leaveIncrements;
    public $staff_id;
    public $filter = null;
    public $search = null;
    public $pagination = null;
    public $sortBy = null;
    public $selected = null;



    protected $rules = [
        'staff' => 'required|min:5',
        'pno' => 'required',
        'email' => '',
        'department' => '',
        'leave_days' => '',
        'dateOfEmployment' => '',
        'workingDays' => '',
        'leaveIncrements' => '',
        'filter' => '',
        'search' => '',
        'pagination' => '',
        'sortBy' => '',
    ];

    public function mount($staff_id)
    {
        if ($staff_id) {
            $this->loadDefaults($staff_id);
        }
    }

    public function loadDefaults($id)
    {
        $staff = ModelsStaff::find($id);
        $this->staff = $staff->staff;
        $this->pno = $staff->pno;
        $this->email = $staff->email;
        $this->department = $staff->department;
        $this->leave_days = $staff->leave_days;
        $this->dateOfEmployment = $staff->dateOfEmployment;
        $this->workingDays = $staff->workingDays;
        $this->leaveIncrements = $staff->leaveIncrements;
        $this->staff_id = $staff->id;
    }
    public function render()
    {
        $departments = Department::all();
        $query = ModelsStaff::query();
        $query = $query->with('dep');
        if ($this->filter) {
            if ($this->filter == "unassigned") {
                $query->whereNull('assigned_to_email');
            } elseif ($this->filter == "unresponsive") {
                $query->whereNull('root_cause')->whereNotNull('assigned_to_email');
            } elseif ($this->filter == "review") {
                $query->whereNotNull('root_cause')->where('finalized', 0);
            } elseif ($this->filter == "toMe") {
                $query->where('assigned_to_email', Auth::user()->email)->whereNotNull('root_cause')->where('finalized', 0);
            } else {
                $query->where('finalized', $this->filter);
            }
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
            $staff_list = $query->paginate($this->pagination);;
        } else {
            $staff_list = $query->paginate(10);
        }



        return view('livewire.staff')->with(compact('departments', 'staff_list'));
    }

    public function saveStaff()
    {
        $this->validate([
            'staff' => 'required|min:5',
            'pno' => 'required|min:2',
            'email' => '',
            'department' => 'required',
            'leave_days' => 'required',
            'dateOfEmployment' => 'required',
            'workingDays' => 'required',
            'leaveIncrements' => 'required|numeric',
        ]);
        ModelsStaff::create(array(
            'staff' => $this->staff,
            'pno' => $this->pno,
            'email' => $this->email,
            'department' => $this->department,
            'leave_days' => $this->leave_days,
            'dateOfEmployment' => $this->dateOfEmployment,
            'workingDays' => $this->workingDays,
            'leaveIcrements' => $this->leaveIncrements,
        ));
    }
    public function updateStaff($id)
    {
        $this->validate([
            'staff' => 'required|min:5',
            'pno' => 'required|min:2',
            'email' => '',
            'department' => 'required',
            'leave_days' => 'required',
            'dateOfEmployment' => 'required',
            'workingDays' => 'required',
            'leaveIncrements' => 'required|numeric',
        ]);
        ModelsStaff::find($id)->update(array(
            'staff' => $this->staff,
            'pno' => $this->pno,
            'email' => $this->email,
            'department' => $this->department,
            'leave_days' => $this->leave_days,
            'dateOfEmployment' => $this->dateOfEmployment,
            'workingDays' => $this->workingDays,
            'leaveIcrements' => $this->leaveIncrements,
        ));
    }

    public function editStaff($id)
    {
        $this->loadDefaults($id);
        $this->emit('edit');
    }
    public function addStaff()
    {
        $this->staff = '';
        $this->pno = '';
        $this->email = '';
        $this->department = '';
        $this->leave_days = '';
        $this->dateOfEmployment = '';
        $this->workingDays = '';
        $this->leaveIncrements = '';
        $this->staff_id = null;
        $this->emit('edit');
    }

    public function resetPassword($id)
    {
        $staff = ModelsStaff::find($id);
        User::where('pno', $staff->pno)->update(array(
            'password' => Hash::make($staff->pno)
        ));
        $this->message('Password Reset to :' . $staff->pno);
    }

    public function resignStaff($id)
    {
    }

    public function message($message)
    {
        session()->flash('message', $message);
        $this->emit('message', $message);
    }
}
