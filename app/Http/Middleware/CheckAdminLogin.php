<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;
use App\Data\Auth\ServiceData;

class CheckAdminLogin
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
     * 
     * @author zhoutao
     * @date   2017.8.21
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
            $uid = $tokenFac->checkAdminAccessToken($accessToken);
            $this->session->token=$accessToken;
            if ($uid === null) {
                $this->Error(ErrorData::$TOKEN_TIMEOUT);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } elseif ($uid ==  0) {
                $this->Error(ErrorData::$USER_NOT_LOGIN);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } elseif ($uid ==  -1) {
                $this->Error(ErrorData::$USER_LOGIN_OTHER);
                return response(
                    json_encode(
                        $this->result,
                        JSON_UNESCAPED_UNICODE
                        |JSON_PRETTY_PRINT
                        |JSON_NUMERIC_CHECK
                    )
                );
            } else {

                $url = '';
                if (array_key_exists('REQUEST_URI', $_SERVER)===true) {
                    $url = $_SERVER["REQUEST_URI"];
                }
               
                $serviceData = new ServiceData;
                if ($serviceData->checkAuth($url, $uid)) {
                    $this->session->userid=$uid;
                    return $next($request);
                }

                 
            }
        }
    }
}
