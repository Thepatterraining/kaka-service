<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use App\Http\Utils\Session;
use App\Data\User\UserData;
use App\Data\User\UserVpData;
use App\Http\Adapter\User\UserVpAdapter;

class CheckVp
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

        $request = $this->request->all();
        $data = new UserVpData();
        $adapter = new UserVpAdapter();

        $userid = $this->session->userid;
        $vpInfo = $data->getUser($userid);

        if (empty($vpInfo)) {
            $this->Error(ErrorData::$TOKEN_NOT_FOUND);
            return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
        } else {
            if ($data->isEnable($userid) === false) {
                $this->Error(ErrorData::$TOKEN_NOT_FOUND);
                return response(
                    json_encode(
                        $this->result,
                        JSON_UNESCAPED_UNICODE
                        |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                    )
                );
            } else {
                return $next($request);
            }
        }
    }
}
