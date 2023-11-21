<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckAdmin extends Middleware
{

    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards)
    {
        $auth = Filament::auth();

        if (!$auth->check()) {
            $this->unauthenticated($request, $guards);

            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $auth->user();


        if ($user instanceof FilamentUser) {
            if ($user->role && $user->role_code != 'user_admin') {
                abort(403);
            }
        }
        return;
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}
