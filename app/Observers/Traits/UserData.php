<?php

namespace App\Observers\Traits;

use Illuminate\Support\Facades\Auth;

trait UserData
{
    public function getUser()
    {
        $user = Auth::user();
        $userMail = $user->mail[0];
        return $userMail;
    }
}
