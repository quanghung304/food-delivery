<?php

namespace App\Http\Middleware;

use App\Libraries\JsonResponseBuilder;
use Illuminate\Http\Response;
use Closure;
use Illuminate\Http\Request;

class ApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $original = $response->getOriginalContent();

        $all = $response->headers->all();
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $code = $response->getStatusCode();
            $original = (array) $original;
            if (isset($original['code'])) {
                $code = $original['code'];
            }
            $message = __('api.http_error');
            if (!empty($original['message'])) {
                $message = $original['message'];
            }
            if($code == 422){
                // $message = array_values($original['errors'])[0];
                $message = $original['message'];
                unset($original['message']);
            }
                
            $original = JsonResponseBuilder::errorWithMessageAndData($code, $message, $original);
        } else {
            $original = JsonResponseBuilder::success($original);
        }

        $response->setContent($original->getContent());

        return $response;
    }
}
