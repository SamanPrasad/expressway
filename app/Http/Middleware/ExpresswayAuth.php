<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpresswayAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->is('users') && (auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Owner' && auth()->user()->role !== 'Manager')){
            return redirect('/');
        }elseif($request->is('user/*') && (auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Owner')){
                return redirect('/');
        }elseif($request->is('buses') && (auth()->user()->role !== 'Data Entry' && auth()->user()->role !== 'Owner' && auth()->user()->role !== 'Manager')){
            return redirect('/');
        }elseif($request->is('bus-routes') && (auth()->user()->role !== 'Data Entry' && auth()->user()->role !== 'Owner'  && auth()->user()->role !== 'Manager')){
            return redirect('/');
        }elseif($request->is('trips') && (auth()->user()->role !== 'Data Entry' && auth()->user()->role !== 'Owner'  && auth()->user()->role !== 'Manager')){
            return redirect('/');
        }

        return $next($request);
    }
}
