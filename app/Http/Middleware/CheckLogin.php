<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;

class CheckLogin
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
            $tokenFac = new AccessToken();
            $accessToken= $request->input("accessToken");
           
        if ($accessToken == null) {
            $this->Error(ErrorData::$TOKEN_NOT_FOUND);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        } else {
            $userid = $tokenFac->checkAccessToken($accessToken);
            $this->session->token=$accessToken;
            if ($userid === null) {
                $this->Error(ErrorData::$TOKEN_TIMEOUT);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } elseif ($userid["userid"] ==  0) {
                $this->Error(ErrorData::$USER_NOT_LOGIN);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } else {
                $this->session->userid=$userid["userid"];
                 return $next($request);
            }
        }
    }
}
