<?php

namespace App\Http\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class WebhookController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Nutgram $bot)
    {
        $bot->run();
        return response([
            'success' => true,
            'code' => 200,
            'message' => 'bot successfully started',
            'payload' => []
        ])->json();
    }
}
