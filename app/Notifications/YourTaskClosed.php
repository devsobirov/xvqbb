<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourTaskClosed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return $notifiable->telegram_chat_id ? ['database', 'telegram'] : ['database'];
    }


    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content("Salom aleykum " . $notifiable->name . ", sizning bo'limga qarashli topshiriq ijrosi yakunlandi. \r\n")
            ->line("*Topshiriq: *" . $this->task?->title . " (".$this->task->code.")")
            ->line("*Vaqt: *" . $this->task?->finished_at->format('d-M-Y H:i'))
            ->button('Batafsil', route('head.process.task', $this->task->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return "Sizning bo'limga qarashli topshiriq (№ ".$this->task->code.") topshiriq ijrosi yakunlandi.";
    }
}
