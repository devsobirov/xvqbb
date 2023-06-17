<?php

namespace App\Notifications;

use App\Models\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourProcessCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Process $process, public string $username = '')
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
            ->content("Salom aleykum " . $notifiable->name . ", filialingiz uchun topshiriq (". $this->process->task->code .") ijrosi ko'rik uchun yuborildi: \r\n")
            ->line("*Topshiriq: *" . $this->process->task?->title . " (".$this->process->task->code.")")
            ->line("*Filial: *" . $this->process->branch?->name)
            ->line("*Ma'sul: *" . $this->username)
            ->line("*Status: *" . $this->process->getStatusName())
            ->line("*Vaqt: *" . $this->process?->completed_at->format('d-m-Y H:i'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return $this->process?->branch?->name ." filiali topshiriq (№ ".$this->process->task->code.") ijrosi yakunladi \r\n";
    }
}
