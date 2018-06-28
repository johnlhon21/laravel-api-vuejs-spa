<?php

namespace App\Observers;

use App\Models\AuthClient;
use App\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function deleted(User $user)
    {
        $authClient = AuthClient::where('user_id', $user->id);

        if ($authClient->first()){
            $authClient->delete();
        }
    }
}
