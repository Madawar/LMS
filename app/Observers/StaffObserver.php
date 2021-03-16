<?php

namespace App\Observers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffObserver
{
    /**
     * Handle the staff "created" event.
     *
     * @param \App\Models\Staff $staff
     * @return void
     */
    public function created(Staff $staff)
    {
        User::create(array(
            'name' => $staff->staff,
            'email' => $staff->email ?? $staff->pno.'@afske.aero',
            'password' => Hash::make($staff->pno),
            'role' => $staff->role,
            'pno' => $staff->pno
        ));
    }

    /**
     * Handle the staff "updated" event.
     *
     * @param \App\Models\Staff $staff
     * @return void
     */
    public function updated(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "deleted" event.
     *
     * @param \App\Models\Staff $staff
     * @return void
     */
    public function deleted(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "restored" event.
     *
     * @param \App\Models\Staff $staff
     * @return void
     */
    public function restored(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "force deleted" event.
     *
     * @param \App\Models\Staff $staff
     * @return void
     */
    public function forceDeleted(Staff $staff)
    {
        //
    }
}
