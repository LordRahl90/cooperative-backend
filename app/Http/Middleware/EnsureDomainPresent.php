<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;

class EnsureDomainPresent
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $account = $request->route()->parameter('account');
        if (Company::where('slug', $account)->count() == 0) {
            session()->flush();
            Flash::error("Invalid account");
            return redirect()->to("/");
        }
        return $next($request);
    }
}
