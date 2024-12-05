<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;
use App\Models\User;

class NewMessageNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $sender;

    public function __construct(Message $message, User $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $limitedMessage = \Str::limit($this->message->message, 60);
        return [
            'message' => "{$this->sender->name} sent you a new message : {$limitedMessage}",
            'sender_id' => $this->sender->id,
        ];
    }
}

