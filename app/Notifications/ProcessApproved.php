<?php

namespace App\Notifications;

use App\Models\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ProcessApproved extends Notification implements ShouldQueue
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
            ->content("Salom aleykum " . $notifiable->name . ", " .$this->getMessage(). "\r\n")
            ->line("*Topshiriq: *" . $this->process->task?->title . " (".$this->process->task->code.")")
            ->line("*Filial: *" . $this->process->branch?->name)
            ->line("*Ma'sul: *" .  $this->process->department?->name)
            ->line("*Vaqt: *" . $this->process?->approved_at->format('d-m-Y H:i'))
            ->button('Batafsil', route('branch.tasks.show', $this->process->task_id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage()
        ];
    }

    protected function getMessage(): string
    {
        return 'Sizning filial uchun №' .$this->process->code ." raqmli topshiriq ijrosi qilindi \r\n";
    }
}
