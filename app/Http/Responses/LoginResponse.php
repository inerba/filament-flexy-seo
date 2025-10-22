<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $redirect = session('redirect_url') ?? config('fortify.home');
        // Pulizia della url in sessione per evitare redirect futuri non voluti
        session()->forget('redirect_url');

        return redirect()->intended($redirect);
    }
}
