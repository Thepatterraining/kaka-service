<?php

namespace Cybereits\Modules\KYC\Middleware;

use Closure;

class CheckSaleTime
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
        $start = strtotime(config("ico.sale_start"));
        $end = strtotime(config("ico.sale_end"));
        $now = strtotime(date('Y-m-d H:i:s'));

        if ($now < $start) {
            return response(
          json_encode(
              [
                "code"=>"900003",
                "msg"=>"公售未开始",
              ],
              JSON_UNESCAPED_UNICODE
               |JSON_PRETTY_PRINT
          )
        );
        } elseif ($now > $end) {
            return response(
          json_encode(
              [
                "code"=>"900004",
                "msg"=>"公售已经结束",
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
