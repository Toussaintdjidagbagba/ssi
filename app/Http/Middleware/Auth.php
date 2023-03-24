<?php

namespace App\Http\Middleware;

use Closure;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        
        if (auth()->guest()) {
            flash("Vous devez être connecté pour voir cette page")->error();
            
            return redirect('/connexion');
        } 
        //return redirect('/maint');
        return $next($request);
    }
}
