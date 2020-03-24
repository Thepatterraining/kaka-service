<?php

namespace Cybereits\Modules\KYC\Middleware;

use Closure;

class CheckRegTime
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
        $start = strtotime(config("ico.reg_start"));
        $end = strtotime(config("ico.reg_end"));
        $now = strtotime(date('Y-m-d H:i:s'));

        if ($now < $start) {
            return response(
          json_encode(
              [
                "code"=>"900001",
                "msg"=>"公售注册未开始",
              ],
              JSON_UNESCAPED_UNICODE
               |JSON_PRETTY_PRINT
          )
        );
        } elseif ($now > $end) {
            return response(
          json_encode(
              [
                "code"=>"900002",
                "msg"=>"公售注册已经结束",
              ],
              JSON_UNESCAPED_UNICODE
               |JSON_PRETTY_PRINT
          )
            );
        } else {
            return $next($request);
        }
    }
}
