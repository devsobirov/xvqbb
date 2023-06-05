<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotService
{
    private string $token = '';
    private string $endpoint = 'https://api.telegram.org/bot';

    function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN', '');
        $this->endpoint .= $this->token .'/sendMessage';
    }

    public function sendMessage(string $chatId = '', string $content = ''): false|Response
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $content
        ];

        if ($chatId) {
            Log::info('Sending message to telegram', $params);
            return Http::get($this->endpoint, $params);
        }

        Log::warning('Failed sending message to telegram', $params);
        return false;
    }

    public function notify(?User $user, string $content = ''): false|Response
    {
        if ( $user instanceof User && $user->telegram_chat_id) {
            Log::info($user->name . ' selected for sending message to bot');
            return $this->sendMessage($user->telegram_chat_id, $content);
        }

        Log::warning('Unable to send message to user', ['user' => $user]);

        return  false;
    }
}
