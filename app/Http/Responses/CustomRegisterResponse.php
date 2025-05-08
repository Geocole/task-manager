<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('verification.notice')->with('message', 'A verification link has been sent to your email.');
    }
}
