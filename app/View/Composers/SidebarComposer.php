<?php

namespace App\View\Composers;

use App\Models\Leave;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies are automatically resolved by the service container...

    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $notifications = Auth::user()->unreadNotifications;
        $leave_count = Leave::where('staff_id',Auth::user()->id)->count();
        $leave_days = Leave::where('staff_id',Auth::user()->id)->first()->leave_days;
        $view->with('notificationCount', $notifications->count());
        $view->with('leaveCount',  $leave_count);
        $view->with('leaveDays',  $leave_days);
    }
}
