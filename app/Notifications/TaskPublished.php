<?php

namespace App\Notifications;

use App\Models\Task;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TaskPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable->telegram_chat_id ? ['database', 'telegram'] : ['database'];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content("Salom aleykum " . $notifiable->name . ", " . $notifiable->workplace()?->name . " uchun yangi topshiriq qabul qilindi: \r\n")
            ->line("*Mavzu: *" . $this->task->title)
            ->line("*Bo'lim: *" . $this->task->department->name)
            ->line("*Tugash muddati: *" . $this->task->expires_at?->format('d-m-Y'))
            ->button('Batafsil', route('branch.tasks.index'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage($notifiable)
        ];
    }

    protected function getMessage($notifiable): string
    {
        return $notifiable->workplace()?->name . " uchun" .
            $this->task->department->name . " bo'limidan " .
            " yangi topshiriq qabul qilindi: '" . $this->task->title . "'";
    }
}
