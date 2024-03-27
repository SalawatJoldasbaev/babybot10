<?php

namespace App\Telegram\Handlers;

use App\Models\BabyGraft;
use Carbon\Carbon;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class BabyHistoryHandler
{
    public function __invoke(Nutgram $bot, $id, $page): void
    {
        $histories = BabyGraft::orderByDesc('datetime')->where('baby_id', $id)
            ->where('graft_status', 'Keledi')
            ->paginate(perPage: 3, page: $page);
        if ($histories->total() == 0) {
            $bot->answerCallbackQuery(
                callback_query_id: $bot->callbackQuery()->id,
                text: __('telegram.no_data'),
                show_alert: true
            );
            return;
        }
        $text = '';
        $arrayKeyboard = [];
        for ($i = 1; $i <= $histories->lastPage(); $i++) {
            $arrayKeyboard[] = [
                'text' => $page == $i ? "$i ✅" : $i,
                'callback_data' => $page == $i ? "thisPage" : "baby $id $i",
            ];
        }
        $paginate = InlineKeyboardMarkup::make();
        $arrayKeyboard = array_chunk($arrayKeyboard, 3);
        $arrayKeyboard = array_merge($arrayKeyboard, [
            [[
                'text' => __('telegram.back'),
                'callback_data' => 'babies',
            ]]
        ]);

        $paginate->inline_keyboard = $arrayKeyboard;

        foreach ($histories as $history) {
            $text .= "\n\n" . __('telegram.history_baby', [
                    'datetime' => $history->datetime,
                    'graft' => $history->graft->name,
                    'graft_description' => $history->graft->description,
                    'description' => $history->description,
                    'symbol' => $history->datetime > Carbon::now() ? '🟢' : '✅'
                ]);
        }

        $bot->editMessageText(
            text: $text,
            message_id: $bot->messageId(),
            reply_markup: $paginate
        );
    }
}
