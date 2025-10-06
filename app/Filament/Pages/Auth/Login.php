<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => config('cms.default_user.email'),
                'password' => config('cms.default_user.password'),
                'remember' => true,
            ]);
        }
    }
}
