<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class GeneratePasswordAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'generatePassword';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-s-key')
            ->color('info')
            ->action(function (Set $set) {
                $password = Str::password(
                    length: 16,
                    letters: true,
                    numbers: true,
                    symbols: true,
                    spaces: false,
                );

                $set('password', $password);
                $set('passwordConfirmation', $password);

                Notification::make()
                    ->success()
                    ->title(__('Password successfully generated.'))
                    ->send();
            });
    }
}
