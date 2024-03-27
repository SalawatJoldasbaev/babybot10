<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\Patient;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use function Laravel\Prompts\text;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Подтвердите')
                ->action(fn() => $this->verify())
                ->icon('heroicon-m-check-circle'),
            DeleteAction::make(),
        ];
    }

    public function verify(): void
    {
        /* @var $patient Patient */
        $patient = $this->getRecord();
        if (!$patient->is_verified) {
            Telegram::sendMessage(
                text: __('telegram.verified_account'),
                chat_id: $patient->telegram_id,
                reply_markup: ReplyKeyboardMarkup::make(resize_keyboard: true)
                    ->addRow(
                        KeyboardButton::make(text: __('telegram.buttons.graft')),
                        KeyboardButton::make(text: __('telegram.buttons.graft_history'))
                    )
            );
        }
        $this->getRecord()->update([
            'is_verified' => true
        ]);
        Notification::make()
            ->title('Проверено успешно')
            ->success()
            ->send();
    }
}
