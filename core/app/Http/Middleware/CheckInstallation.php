<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {

        try {
            if (site_config('site_url')) {
                return $next($request);
            }
        } catch (\Exception $e) {
            if ($e->getCode() == '42S02' || $e->getCode() == '1045' || $e->getCode() == '3D000') {
                return redirect()->route('install');
            }

            throw $e;
        }

        return redirect()->route('install');
    }
}
