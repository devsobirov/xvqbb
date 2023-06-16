<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourProcessExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return $notifiable->telegram_chat_id ? ['database', 'telegram'] : ['database'];
    }


    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content("Salom aleykum " . $notifiable->name . ", sizning filialga tefishli topshiriq 'Muddatidan o'tgan' xolatiga o'tkazildi. \r\n")
            ->line("*Topshiriq: *" . $this->task?->title . " (".$this->task->code.")")
            ->line("Topshiriq yakuni uchun yana " . Task::CLOSE_AFTER_DAYS_SINCE_EXPIRED." kun muddat beriladi, ijro qabul uchun topshirilmagan taqdirda 'Bajarilmagan' xolatiga o'tkaziladi. \r\n");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return "Topshiriq (№ ".$this->task->code.") xolati o'zgartirildi - ". $this->task->getStatusName() ." \r\n";
    }
}
