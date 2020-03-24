<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Data\API\Email\EmailVerifyFactory;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use Illuminate\Support\Facades\Redis;
use App\Data\ImgVerifyCode\ImgVerifyFac;

class CheckImgValideCode
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
		$validate_array = ["SLT01","SLT06","SLT05"];	
		$send_type = $request->input("type");
        $fac = new ImgVerifyFac();
        $img_verify = $fac -> CreateImgVerify();
		if(in_array($send_type,$validate_array)){
			
            $validate_code = $request->input("validate_code");
            if ($validate_code == null) {
                $this->Error(ErrorData::IMG_CODE_ERROR);
                return response(
                json_encode(
                    $this->result,
                    JSON_UNESCAPED_UNICODE
                    |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );
            } elseif ($img_verify->checkLoginCode($validate_code) === false) {
                $this->Error(ErrorData::IMG_CODE_ERROR);
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
		}else {
			return $next($request);
		}
    }
}
