<?php

namespace App\Telegram\Handlers;

use App\Models\Baby;
use App\Models\Patient;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class BabiesHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $patient = Patient::where('telegram_id', $bot->chatId())->first();
        $babies = Baby::where('patient_id', $patient->id)->get();
        $babiesKeyboard = InlineKeyboardMarkup::make();
        foreach ($babies as $baby) {
            $babiesKeyboard->addRow(
                InlineKeyboardButton::make(text: "$baby->name ({$baby->birthday->format('Y-m-d')})", callback_data: "baby $baby->id 1")
            );
        }
        $bot->editMessageText(
            text: __('telegram.chose_baby'),
            message_id: $bot->messageId(),
            reply_markup: $babiesKeyboard
        );
    }
}
