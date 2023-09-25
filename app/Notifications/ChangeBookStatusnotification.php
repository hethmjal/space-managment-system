<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeBookStatusnotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $book)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('Space managment system')
            ->greeting("Dear {$this->book->name}!")
            ->line("Your request to reserve a space has been {$this->book->status}!")
            ->lineIf($this->book->status == 'accepted', "Your booking start in {$this->book->start_date} from {$this->book->from} to {$this->book->to} and end in {$this->book->end_date}" )
            ->lineIf($this->book->status == 'accepted',"the space is {$this->book->space->name}")
            ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
