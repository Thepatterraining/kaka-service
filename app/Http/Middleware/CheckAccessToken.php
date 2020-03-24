<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;
use Illuminate\Support\Facades\Log;

class CheckAccessToken
{

    use Error;
    private $session;
    public function __construct(Session $session)
    {

          $this->session = $session;
    }
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

            $this->session->token=$accessToken;
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
            $sessionInfo = $tokenFac->checkAccessToken($accessToken);

            if ($sessionInfo === null) {
                $this->Error(ErrorData::$TOKEN_TIMEOUT);
                 return response(
                     json_encode(
                         $this->result,
                         JSON_UNESCAPED_UNICODE
                          |JSON_PRETTY_PRINT
                         |JSON_NUMERIC_CHECK
                     )
                 );
            } else {
                $this->session->userid=$sessionInfo["userid"];
		$this->session->appid = $sessionInfo["appid"];
		$this->session->appName = $sessionInfo["appName"];
                return $next($request);
            }
        }
    }
}
