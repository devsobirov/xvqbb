<?php

namespace App\Notifications;

use App\Models\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class YourProcessTerminated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Process $process)
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
            ->content("Salom aleykum " . $notifiable->name . ", filialingiz uchun topshiriq ijrosi avtomatik yakunlandi: \r\n")
            ->line("*Topshiriq: *" . $this->process->task?->title . " (".$this->process->task->code.")")
            ->line("*Ma'sul: *" . $this->process->department?->name)
            ->line("*Status: *" . $this->process->getStatusName())
            ->line("*Jamg'arilgan ball: *" . $this->process->score)
            ->line("*O'rin: *" . $this->process->position ?? '-')
            ->line("*Vaqt: *" . now()->format('d-m-Y H:i'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return $this->process?->branch?->name ." filiali topshiriq (№ ".$this->process->task->code.") ijrosi avtomatik yakunladi \r\n";
    }
}
