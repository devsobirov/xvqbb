<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourTaskCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?User $user,
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
            ->content("Salom aleykum " . $notifiable->name . ", sizning bo'limga qarashli topshiriq o'chirildi. \r\n")
            ->line("*Topshiriq: *" . $this->taskName . " (".$this->taskId.")")
            ->line("*Vaqt: *" . now()->format('d-M-Y H:i'))
            ->line("*Bajardi: *" . $this->user?->name ?? '?');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return "Sizning bo'limga qarashli topshiriq (№ ".$this->taskId." - ". $this->taskName.") ".($this->user?->name ?? '?') ." tomonidan o'chirildi.";
    }
}
