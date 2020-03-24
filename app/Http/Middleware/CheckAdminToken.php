<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;

class CheckAdminToken
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
            $uid = $tokenFac->checkAdminAccessToken($accessToken);

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
            } else {
                return $next($request);
            }
        }
    }
}
