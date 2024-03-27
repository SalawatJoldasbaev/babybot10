<?php

namespace App\Telegram\Handlers;

use App\Models\BabyGraft;
use SergiX44\Nutgram\Nutgram;

class PatientAnswerHandler
{
    public function __invoke(Nutgram $bot, $type, $id): void
    {
        BabyGraft::find($id)->update([
            'graft_status' => $type == 'yes' ? "Keledi" : "Kelmeydi",
        ]);

        $bot->sendMessage(__('telegram.thank_you_four_answer'));
    }
}
