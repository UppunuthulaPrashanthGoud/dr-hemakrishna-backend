<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            return 'api/v1/unauthenticated'; // You can name whatever route you want
        } else {
            if (!$request->expectsJson()) {
                return route('admin.login');
            }
        }
    }
    }
