<?php

namespace App\Http\Livewire;

use App\Helper;
use App\Models\Approval;
use App\Models\Leave;
use App\Models\User;
use App\Notifications\LeaveRaised;
use App\Notifications\LeaveRelieveRejected;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Notification extends Component
{
    public $filter = 'unread';
    public $leave = null;
    public $notification = null;
    public $readCount = null;
    public $unReadCount = null;

    public function render()
    {
        $user = User::where('pno', Auth::user()->pno)->first();
        if ($this->filter == 'unread') {
            $notifications = $user->unreadNotifications;
        } else {
            $notifications = $user->notifications->whereNotNull('read_at');
        }
        $this->readCount = $user->notifications->whereNotNull('read_at')->count();
        $this->unReadCount = $user->unreadNotifications->count();

        return view('livewire.notification')->with(compact('notifications'));
    }

    public function approveLeave($id)
    {
        $user = Auth::user();
        Approval::where('staff_id', $user->id)->where('leave_id', $id)->update(array(
            'approved' => 1
        ));
        $user->notifications->where('data.leave_id', $id)->where('notifiable_id', $user->id)->markAsRead();
        $this->leave = null;
        if (Auth::user()->role != 'manager') {
            $this->sendManagerNotification($id);
        }
        $this->finalizeLeave($id);
    }
    public function rejectLeave($id)
    {
        $user = Auth::user();
        Approval::where('staff_id', $user->id)->where('leave_id', $id)->update(array(
            'approved' => 0
        ));
        $user->notifications->where('data.leave_id', $id)->where('notifiable_id', $user->id)->markAsRead();
        $this->restartLeave($id);
        $this->leave = null;
    }

    public function sendManagerNotification($id)
    {
        $relieved = Helper::approvedByRelievers($id);
        if ($relieved) {
            $manager_has_unnaproved = Helper::unapprovedByManager($id);
            $unnaprovedByRelievers = Helper::unapprovedLeaves($id);
            $leave = Leave::with('raiser.user')->findOrFail($id);
            if ($manager_has_unnaproved->count() > 0 && $unnaprovedByRelievers->count() == 0) {
                foreach ($manager_has_unnaproved as $app) {
                    foreach ($app->approvers as $approver) {
                        $notify_staff = $approver->staff->user;
                        $notify_staff->notifications()->where('data->leave_id', $id)->where('type', 'App\Notifications\LeaveRaised')->delete();
                        $notify_staff->notify(new \App\Notifications\LeaveRaised($leave, $approver));
                    }
                }
            }
        }
    }

    public function readNotification($id)
    {
        $this->notification = Auth::user()->notifications->where('id', $id)->first();
        $this->leave = Leave::with('raiser', 'approvers.staff')->find($this->notification->data['leave_id']);
    }

    public function filterNotifications($type)
    {
        $this->filter = $type;
    }

    public function restartLeave($id)
    {
        $leave = Leave::with('raiser')->findOrFail($id);
        Approval::where('leave_id', $id)->update(array(
            'approved' => 0
        ));
        $user =  Auth::user();
        DB::table('notifications')
        ->where('data->leave_id', $id)
        ->delete();
        $leave->raiser->user->notify(new \App\Notifications\LeaveRelieveRejected($leave, $user));
        return $leave;
    }

    public function finalizeLeave($id)
    {
        $approvals =  Helper::approvedLeaves($id);
        $leave =  Leave::with('raiser')->find($id);
        if ($approvals->count() == 0) {
            $notify_staff = $leave->raiser->user;
            $notify_staff->notify(new \App\Notifications\LeaveApproved($leave));
        }
    }
}
