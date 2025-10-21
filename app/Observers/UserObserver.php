<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        // Ако няма зададена роля – по подразбиране е "customer"
        if (! $user->role) {
            $user->role = 'customer';
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Пример: изпрати приветствен имейл
        // Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));

        Log::info("👋 New user registered: {$user->email}");
    }
}
