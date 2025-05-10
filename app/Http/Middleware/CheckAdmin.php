<?php

namespace App\Http\Middleware;

use App\Trait\HandleResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    use HandleResponse;
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role != 'admin')
        {   
            return $this->errorsMessage(['error' => "You Must Be Admin"]);
        }
        return $next($request);
    }
}
