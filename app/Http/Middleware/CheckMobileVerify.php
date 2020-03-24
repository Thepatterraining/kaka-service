<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Data\API\SMS\SmsVerifyFactory;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use Illuminate\Support\Facades\Redis;

class CheckMobileVerify
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
     */
    public function handle($request, Closure $next)
    {
         $verify= $request->input("verify");
        if ($request->has("newPhone")) {
            $phone = $request->input("newPhone");
        } elseif ($request->has("phone")) {
            $phone = $request->input("phone");
        } elseif ($request->has("data.mobile")) {
            $phone = $request->input("data.mobile");
        } elseif ($request->has("user.mobile")) {
            $phone = $request->input('user.mobile');
        }
        if (empty($verify)) {
             $this->Error(ErrorData::$VERIFY_REQUIRED);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        } elseif ($this->session==null) {
            $this->Error(ErrorData::$TOKEN_NOT_FOUND);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        }

        //判断是否正确
        $smsFac = new SmsVerifyFactory;
        $smsData = $smsFac->CreateSms();
        $smsRes = $smsData->CheckSms($phone, $verify);

        if ($smsRes === false) {
            $this->Error(ErrorData::$VERIFY_FALSE);
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
