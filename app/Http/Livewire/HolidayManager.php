<?php

namespace App\Http\Livewire;

use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class HolidayManager extends Component
{
    public $date;
    public $holiday_name;
    public $holiday_id = null;
    public $filter = null;
    public $search = null;
    public $pagination = null;
    public $sortBy = null;
    public $startDate = null;
    public $endDate = null;
    public $holiday_hash = null;


    protected $rules = [
        'date' => 'required',
        'holiday_name' => 'required',
        'filter' => '',
        'search' => '',
        'pagination' => '',
        'sortBy' => '',
        'holiday_id' => '',
        'holiday_hash'=>''
    ];

    public function loadDefaults($id)
    {
        $holiday = Holiday::find($id);
        $holidayStartAndEnd =  Holiday::select(DB::raw('min(date) as startDate, max(date) as endDate'))->where('hashed', $holiday->hashed)->first();
        $this->holiday_name = $holiday->holiday_name;
        $this->startDate = $holidayStartAndEnd->startDate;
        $this->endDate = $holidayStartAndEnd->endDate;
        $this->holiday_id = $holiday->id;
        $this->holiday_hash = $holiday->hashed;
        $this->date = $holidayStartAndEnd->startDate . ' to ' . $holidayStartAndEnd->endDate;
    }
    public function empty()
    {

        $this->holiday_name = '';
        $this->date = '';
        $this->holiday_hash = '';
        $this->holiday_id = null;
    }

    public function render()
    {
        $query = Holiday::query();
        // $query = $query->with('manager');
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
            $holidays = $query->paginate($this->pagination);;
        } else {
            $holidays = $query->paginate(10);
        }
        return view('livewire.holiday-manager')->with(compact('holidays'));
    }

    public function saveHoliday()
    {
        $this->validate([
            'date' => 'required',
            'holiday_name' => 'required',
        ]);
        $startDate = Carbon::parse(Str::before($this->date, 'to'));
        $endDate = Carbon::parse(Str::after($this->date, 'to'));
        $period = CarbonPeriod::between($startDate, $endDate);
        $hashed = Str::random(10);
        foreach ($period as $date) {
            Holiday::create(array(
                'date' => $date,
                'holiday_name' => $this->holiday_name,
                'hashed' => $hashed
            ));
        }
        $this->message('Holiday Saved');
        $this->empty();
    }
    public function updateHoliday($hash)
    {
        $this->validate([
            'date' => 'required',
            'holiday_name' => 'required',
        ]);
        Holiday::where('hashed', $hash)->delete();
        $startDate = Carbon::parse(Str::before($this->date, 'to'));
        $endDate = Carbon::parse(Str::after($this->date, 'to'));
        $period = CarbonPeriod::between($startDate, $endDate);
        $hashed = Str::random(10);
        foreach ($period as $date) {
            Holiday::create(array(
                'date' => $date,
                'holiday_name' => $this->holiday_name,
                'hashed' => $hashed
            ));
        }
        $this->message('Holiday Saved');
        $this->empty();
    }
    public function message($message)
    {
        session()->flash('message', $message);
        $this->emit('message', $message);
    }

    public function editHoliday($id)
    {
        $this->loadDefaults($id);
        $this->emit('edit');
    }

    public function deleteHoliday($hash)
    {
        Holiday::where('hashed', $hash)->delete();
        $this->empty();
    }
}
