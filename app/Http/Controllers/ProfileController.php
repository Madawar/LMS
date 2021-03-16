<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $verified = Staff::where('pno', Auth::user()->pno)->first()->detailsVerified;
        $staff = Staff::where('pno', Auth::user()->pno)->first();
        return view('profile')->with(compact('departments', 'verified', 'staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => '',
            'telephone' => 'required',
            'department' => 'required',
            'password' => 'required',
            'password_confirm' => 'same:password'
        ]);

        Staff::where('pno', Auth::user()->pno)->update(array(
            'telephone' => $request->telephone,
            'email' => $request->email,
            'department' => $request->department,
            'detailsVerified' => 1
        ));

        User::find(Auth::user()->id)->update(array(
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ));

        return redirect()->action([LeaveController::class, 'index']);
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
        //
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
}
