<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;
use App\Traits\SearchTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use DB;


class LeaveList extends Component
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
        $query->where('staff_id', Auth::user()->id);
        if ($this->pagination) {
            $leaves = $query->paginate($this->pagination);;
        } else {
            $leaves = $query->paginate(10);
        }


        return view('livewire.leave-list')->with(compact('leaves'));
    }

    public function deleteLeave($id)
    {
        \App\Models\Leave::destroy($id);
        DB::table('notifications')
            ->where('data->leave_id', $id)
            ->delete();
    }
}
