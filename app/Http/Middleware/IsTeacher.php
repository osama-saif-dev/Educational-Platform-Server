<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class IsTeacher
{
    use HandleResponse;
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->role != 'teacher')
        {
            return $this->errorsMessage(['error' => "You Must Be Teacher"]);
        }
        return $next($request);
    }
}
