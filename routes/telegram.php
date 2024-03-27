<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\StartCommand;
use App\Telegram\Handlers\BabiesHandler;
use App\Telegram\Handlers\BabyHistoryHandler;
use App\Telegram\Handlers\GraftHistoryHandler;
use App\Telegram\Handlers\GraftInfoHandler;
use App\Telegram\Handlers\PatientAnswerHandler;
use SergiX44\Nutgram\Nutgram;

$bot->registerCommand(StartCommand::class);

$bot->onCallbackQueryData("answer {type} {id}", PatientAnswerHandler::class);
$bot->onCallbackQueryData("baby {id} {page}", BabyHistoryHandler::class);
$bot->onCallbackQueryData("babies", BabiesHandler::class);
$bot->onText('💉Privivka', GraftInfoHandler::class);
$bot->onText('📋Emlash tarixi', GraftHistoryHandler::class);

//ma'nzil
//telefon
