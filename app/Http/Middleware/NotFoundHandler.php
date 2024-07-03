<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotFoundHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Execute the next middleware in the pipeline and get the response
        $response = $next($request);

        // Check if the response status is 404
        if ($response->status() === 404) {
            // If 404, return a custom 404 error view
            return response()->view('404-Error-Not-found', [], 404);
        }

        // If not 404, return the original response
        return $response;
    }
}


