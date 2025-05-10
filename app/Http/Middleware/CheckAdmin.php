<?php

namespace App\Http\Middleware;

use App\Trait\HandleResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    use HandleResponse;
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->role != 'admin')
        {   
            return $this->errorsMessage(['error' => "You Must Be Admin"]);
        }
        return $next($request);
    }
} 

?>