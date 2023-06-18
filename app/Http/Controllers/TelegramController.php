<?php

namespace App\Http\Controllers;

use App\Models\TelegramToken;
use App\Models\User;
use App\Services\TelegramBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Symfony\Component\String\u;

class TelegramController extends Controller
{
    public function setWebhook()
    {
        //'https://api.telegram.org/bot{TOKEN}/getWebhookInfo'

        return redirect('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN', '').'/setWebhook?url='.secure_url(route('telegram.getUpdates')));
    }

    public function start()
    {
        $token = TelegramToken::where('user_id', auth()->id())->first();
        if (!$token) {
            $token = TelegramToken::create([
                'user_id' => auth()->id(),
                'token' => strtolower(Str::random(8))
            ]);
        }

        return redirect('https://telegram.me/'. env('TELEGRAM_BOT_NAME').'?start='.$token->token);
    }

    public function getUpdates(Request $request)
    {
        $text = false;
        $chatId = false;

        $updates = $request->all();
        \Log::debug('telegram-get-updates', $updates);

        if (!empty($updates['message']['chat']['id'])) {
            // Chat ID
            $chatId = $updates['message']['chat']['id'];
        }

        if (!empty($updates['message']['text'])) {
            $text = strtolower(trim($updates['message']['text']));
        }

        if ($chatId && $text && $secret = $this->extractToken($text)) {
            $token = TelegramToken::where('token', $secret)->first();
            $user = null;

            if ($token && $user = User::find($token?->user_id)) {
                $user->telegram_chat_id = $chatId;
                $user->save();
                $token->delete();

                \Log::info($user->name . ' subscribed to telegram bot');
                (new TelegramBotService())->notify($user, 'Salom '. $user->name . '! Siz bot orqali bildirishnomalarga obuna bo\'ldingiz!' );

                return 'OK';
            } else {
                \Log::alert('Telegram bot subscription failed', [
                    'token' => $secret,
                    'user' => $user ?? null
                ]);

                (new TelegramBotService())->sendMessage($chatId, "Bildirishnomalarga obuna bo'lish muvaffaqiyatsiz yakunlandi, qayta urinib ko'ring yoki admin bilan bog'laning");
            }

        }

        return 'OK';
    }

    public function unsubscribe(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $chatId = $user->telegram_chat_id;
        $user->telegram_chat_id = null;
        $user->save();

        \Log::info($user->name . ' unsubscribed telegram bot');

        (new TelegramBotService())->sendMessage($chatId, "Ciao, ". $user->name .'. Siz bildirishnomalar obunasini to\'xtatdingiz. Shaxsiy kabientdagi xavola orqali qayta ulanishingiz mumkin. Omon bo\'ling!');
        return redirect()->back()->with('success', 'Botga obuna muvaffiqayli to\'xtatildi!');
    }

    private function extractToken($text): ?string {

        if (str_starts_with($text, 'start') || str_starts_with($text, '/start')) {
            $exploded = explode(' ', $text);

            if (count($exploded) > 1) {
                return trim($exploded[1]); // "/start abcd" => "abcd"
            }
        }

        return null;
    }
}
