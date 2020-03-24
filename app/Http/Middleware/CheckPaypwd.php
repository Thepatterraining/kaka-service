<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;
use App\Data\User\UserData;

class CheckPaypwd
{
    private $session;
    public function __construct(Session $session)
    {
        
        $this->session = $session;
    }
    use Error;
    
    //protected $result ;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $paypwd= $request->input("paypwd");
        if ($paypwd==null) {
             $this->Error(ErrorData::$PAY_PWD_REQUIRED);
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
        if ($this->session->userid == 0) {
            $this->Error(ErrorData::$USER_NOT_LOGIN);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        } else {
            $userData = new UserData();
            $user = $userData->get($this->session->userid);
            if ($userData->checkPaypwd($user, $paypwd)==true) {
                return $next($request);
            } else {
                $this->Error(ErrorData::$USER_PAY_WRONG);
                return response(
                    json_encode(
                        $this->result,
                        JSON_UNESCAPED_UNICODE
                        |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                    )
                );
            }
        }
    }
}
