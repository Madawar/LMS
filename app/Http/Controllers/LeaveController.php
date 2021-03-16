<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = null;
        return view('leave.view_leaves')->with(['id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = null;
        return view('leave.create_leave')->with(['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('leave.create_leave')->with(['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function toWord($id)
    {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Storage::path('Template.docx'));
        $leave =  Leave::find($id);
        $staff = Staff::find($leave->staff_id);


        //Modify
        $leave->reportBack =  Carbon::parse($leave->endDate)->addDay()->format('j-M-y');
        $leave->startDate = Carbon::parse($leave->startDate)->format('j-M-y');
        $leave->endDate = Carbon::parse($leave->endDate)->format('j-M-y');
        $leave->leaveType = Str::upper($leave->leaveType);
        $today = Carbon::now();
        //TODO Fix date Of Employment
        if ($today->greaterThan(carbon::parse($staff->dateOfEmployment))) {
            $staff->annualLeaveDate = Carbon::parse($staff->dateOfEmployment)->setYear($today->addYear()->year)->format('j-M-y');
        } else {
            $staff->annualLeaveDate = Carbon::parse($staff->dateOfEmployment)->setYear($today->year)->format('j-M-y');
        }
        $staff->annualLeaveDate = Carbon::parse($staff->dateOfEmployment)->setYear()->format('j-M-y');
        $staff->dateOfEmployment = Carbon::parse($staff->dateOfEmployment)->format('j-M-y');
        $staff->department = $staff->dep->department;

        //Approvers
        $approvers = [];
        $index = 1;
        foreach ($leave->approvers->where('level','!=', 'Department Manager') as $approver) {
            $key_person = 'person' . $index;
            $approvers[$key_person] = $approver->staff->staff;
            $index = $index + 1;
        }
        $index = 1;
        foreach ($leave->approvers->where('level', 'Department Manager') as $approver) {
            $key_person = 'manager' . $index;
            $approvers[$key_person] = $approver->staff->staff;
            $index = $index + 1;
        }
        $r = array_merge($leave->toArray(), $staff->toArray(), $approvers);

        //Managers


        $replacements = array(
            Arr::except($r, ['dep','approvers'])
        );
      //  dd($replacements);
        $templateProcessor->cloneBlock('block_name', 0, true, false, $replacements);
        $filename = Str::random(5) . '.docx';
        $path = 'public/' . $filename;
        $templateProcessor->saveAs(Storage::path($path));
       // return $path;
       return  redirect('storage/' . $filename);
        return $path;
    }
}
