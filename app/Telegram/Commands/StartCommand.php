<?php

namespace App\Telegram\Commands;

use App\Models\Patient;
use App\Telegram\Conversations\RegisterConversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = '';

    public function handle(Nutgram $bot): void
    {
        if (Patient::where('telegram_id', $bot->chatId())->first()) {
            $bot->sendMessage(
                text: __('telegram.start_message'),
                reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                    ->addRow(
                        KeyboardButton::make(text: __('telegram.buttons.graft')),
                        KeyboardButton::make(text: __('telegram.buttons.graft_history'))
                    )
            );
        } else {
            RegisterConversation::begin(
                bot: $bot,
                userId: $bot->userId(),
                chatId: $bot->chatId(),
            );
        }
    }
}
