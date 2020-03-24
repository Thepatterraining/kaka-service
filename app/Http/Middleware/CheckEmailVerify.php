<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Data\API\Email\EmailVerifyFactory;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use Illuminate\Support\Facades\Redis;

class CheckEmailVerify
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
        if ($request->has("newEmail")) {
            $email = $request->input("newEmail");
        } elseif ($request->has("email")) {
            $email = $request->input("email");
        } elseif ($request->has("data.email")) {
            $email = $request->input("data.email");
        } elseif ($request->has("user.email")) {
            $email = $request->input('user.email');
        } elseif ($requesr->has("data.userEmail")) {
            $email = $request->input("data.userEmail");
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
        $emailFac = new EmailVerifyFactory;
        $emailData = $emailFac->CreateEmail();
        $emailRes = $emailData->CheckEmail($email, $verify);

        if ($emailRes === false) {
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
