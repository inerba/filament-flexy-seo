<?php

namespace App\Filament\Actions;

use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Verified;

class VerifyCustomerEmailAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'verifyCustomerEmail';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Verifica')
            ->icon('heroicon-s-check-badge')
            ->iconButton()
            ->color('success')
            ->tooltip('Verifica manualmente l\'email del cliente')
            ->requiresConfirmation()
            ->modalHeading('Verificare questo cliente?')
            ->modalDescription('Questa azione imposterà l\'email del cliente come verificata.')
            ->modalSubmitActionLabel('Verifica')
            ->visible(function (): bool {
                $record = $this->getRecord();

                return $record instanceof Customer && ! $record->hasVerifiedEmail();
            })
            ->action(function (): void {
                $record = $this->getRecord();

                if (! $record instanceof Customer || $record->hasVerifiedEmail()) {
                    return;
                }

                if ($record->markEmailAsVerified()) {
                    event(new Verified($record));
                }

                Notification::make()
                    ->success()
                    ->title('Cliente verificato correttamente.')
                    ->send();
            });
    }
}
