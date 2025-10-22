<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $redirect = session('redirect_url') ?? config('fortify.home');

        // Pulizia della url in sessione per evitare redirect futuri non voluti
        session()->forget('redirect_url');

        return redirect()->intended($redirect);
    }
}
