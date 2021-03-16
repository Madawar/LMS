<?php

namespace App\Notifications;

use App\Models\Approval;
use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRaised extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Leave $leave, Approval $approval, $reraised = null)
    {
        $this->leave = $leave;
        $this->approval = $approval;
        $this->reraised = $reraised;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'leave_id' => $this->leave->id,
            'raiser' => $this->leave->raiser->staff,
            'startDate' => $this->leave->startDate,
            'endDate' => $this->leave->endDate,
            'approval_id' => $this->approval->id,
            'reraised' => $this->reraised
        ];
    }
}
