<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use Illuminate\Support\Facades\Redis;
use App\Data\User\UserData;

class CheckUserStatus
{

    private $session;
    public function __construct(Session $session)
    {
        
        $this->session = $session;
    }
    use Error;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * 
     * 判断用户状态是否正常
     * @author zhoutao
     * @date   2017.8.30
     */
    public function handle($request, Closure $next)
    {
        if ($this->session==null) {
            $this->Error(ErrorData::$TOKEN_NOT_FOUND);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        }
        $userid = $this->session->userid;
 	info('check status user id :'.$userid); 
        $userData = new UserData;
        $status = $userData->getUserStatus($userid);
        
        if ($status === UserData::USER_STATUS_FROZEN) {
            $this->Error(ErrorData::USER_STATUS_FROZEN);
                    return response(
                        json_encode(
                            $this->result,
                            JSON_UNESCAPED_UNICODE
                            |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                        )
                    );
        }
        return $next($request);
        
    }
}
