<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Staff;
use Livewire\Component;

class DepartmentForm extends Component
{
    public $selected = [];
    public $department_manager;
    public $number_of_relievers;
    public $supervisors;
    public $department;
    public $department_id = null;
    public $filter = null;
    public $search = null;
    public $pagination = null;
    public $sortBy = null;


    protected $rules = [
        'department_manager' => 'required',
        'number_of_relievers' => 'required',
        'department' => '',
        'filter' => '',
        'search' => '',
        'pagination' => '',
        'sortBy' => '',
        'department_id' => ''
    ];



    public function loadDefaults($id)
    {
        $department = Department::find($id);
        $this->department = $department->department;
        $this->number_of_relievers = $department->number_of_relievers;
        $this->department_manager = $department->department_manager;
        $this->supervisors = $department->supervisors;
    //    $this->selected = $department->supervisors;
        $this->department_id =  $department->id;
     //   $this->emit('selecting', json_decode($this->selected));
    }

    public function render()
    {
        $staff = Staff::orderBy('staff')->get();
        $supervisor_list = Staff::pluck('staff', 'id')->toArray();
        $query = Department::query();
        $query = $query->with('manager');
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
            $departments = $query->paginate($this->pagination);;
        } else {
            $departments = $query->paginate(10);
        }
        $department_id = $this->department_id;
        $departments->transform(function ($department) {
            $list = json_decode($department->supervisors);
            $staff = array();

            if ($list) {
                foreach ($list as $item) {
                    $staff[] = Staff::find((int)$item);
                }
            }
            $department->supervisors = $staff;
            return $department;
        });
        return view('livewire.department-form')->with(compact('staff', 'supervisor_list', 'departments', 'department_id'));
    }

    public function saveDepartment()
    {
        $this->validate([
            'department_manager' => 'required',
            'number_of_relievers' => 'required|numeric',
            'department' => 'required',
            'supervisors' => '',
        ]);
        $department = Department::create(array(
            'department_manager' => $this->department_manager,
            'supervisors' => json_encode($this->supervisors),
            'department' => $this->department,
            'number_of_relievers' => $this->number_of_relievers,
        ));
        $this->department_id = $department->id;
    }

    public function updateDepartment($id)
    {
        $this->validate([
            'department_manager' => 'required',
            'number_of_relievers' => 'required|numeric',
            'department' => 'required',
            'supervisors' => 'required',
        ]);
        if(is_array($this->supervisors)){

        }else{
            $this->supervisors = [];
        }

        Department::find($id)->update(array(
            'department_manager' => $this->department_manager,
            'supervisors' => json_encode($this->supervisors),
            'department' => $this->department,
            'number_of_relievers' => $this->number_of_relievers,
        ));
    }

    public function editDepartment($id)
    {
        $this->loadDefaults($id);
        $this->emit('edit');
    }

    public function addDepartment()
    {
        $this->department = '';
        $this->number_of_relievers = '';
        $this->department_manager = '';
        $this->supervisors = '';
    //    $this->selected = $department->supervisors;
        $this->department_id = null;
        $this->emit('edit');
    }

}
