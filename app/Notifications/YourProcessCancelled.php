<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourProcessCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $taskName,
        public string $taskId
    ){}

    public function via(object $notifiable): array
    {
        return $notifiable->telegram_chat_id ? ['database', 'telegram'] : ['database'];
    }


    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content("Salom aleykum " . $notifiable->name . ", sizning filailga qarashli topshiriq o'bekor qilindi. \r\n")
            ->line("*Topshiriq: *" . $this->taskName . " (".$this->taskId.")")
            ->line("*Vaqt: *" . now()->format('d-M-Y H:i'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return "Sizning filialga qarashli topshiriq (". $this->taskName.") bekor qilindi.";
    }
}
