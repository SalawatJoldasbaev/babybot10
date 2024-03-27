<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class GraftInfoHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage(__('telegram.graft_info'));
    }
}
