<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use Illuminate\Support\Facades\Redis;
use App\Data\User\UserData;

class CheckUserIdno
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
        $userData = new UserData;
        $idno = $userData->getUserIdno($userid);
        $isSetIdno = $userData->idnoIsEmpty();
	info('check id no '.$idno);        
        if (empty($idno) && $isSetIdno === false) {
            $this->Error(ErrorData::USER_IDNO_NOT_FOUND);
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
