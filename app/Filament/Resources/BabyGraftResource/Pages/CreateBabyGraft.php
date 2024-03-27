<?php

namespace App\Filament\Resources\BabyGraftResource\Pages;

use App\Filament\Resources\BabyGraftResource;
use App\Models\Baby;
use App\Models\Graft;
use App\Models\Patient;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class CreateBabyGraft extends CreateRecord
{
    protected static string $resource = BabyGraftResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return parent::mutateFormDataBeforeCreate($data);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['graft_status'] = "Juwap ele aniq emes";
        $model = static::getModel()::create($data);
        $graft = Graft::find($data['graft_id']);
        $baby = Baby::find($data['baby_id'])->load('patient');
        Telegram::sendMessage(
            text: __('telegram.created_graft_for_baby', [
                'datetime' => $data['datetime'],
                'graft' => $graft->name,
                'graft_description' => $graft->description,
                'baby' => $baby->name,
                'description' => $data['description']
            ]),
            chat_id: $baby->patient->telegram_id,
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(
                    InlineKeyboardButton::make(text: __('telegram.yes'), callback_data: "answer yes $model->id"),
                    InlineKeyboardButton::make(text: __('telegram.no'), callback_data: "answer no $model->id")
                )
        );
        $model->update([
            'message_sent' => true
        ]);
        return $model;
    }
}
