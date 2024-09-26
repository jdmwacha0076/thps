<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity) {
                $expirationTime = config('session.timeout', 1) * 10;
                $currentTime = time();

                if ($currentTime - $lastActivity > $expirationTime) {

                    Auth::guard('web')->logout();
                    session()->invalidate();
                    return redirect()->route('welcome')->with('error', 'Time out error .');
                }
            }
        }

        session(['last_activity' => time()]);

        return $next($request);
    }
}
