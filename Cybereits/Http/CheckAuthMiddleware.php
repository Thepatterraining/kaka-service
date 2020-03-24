<?php

namespace Cybereits\Http; 

use Closure;

class CheckAuthMiddleware
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
    


        $time =  $request -> query("timestamp");
        $checkcode = $request -> query("checkcode");

        $chk = md5($time."Pa99");
        if ($chk != $checkcode) {
          return response(
            json_encode(
                [
                  "code"=>"00001",
                  "msg"=>"签权不通过",
                ],
                JSON_UNESCAPED_UNICODE
                 |JSON_PRETTY_PRINT
            )
              );
        }

        
        return $next($request);
    }
}
