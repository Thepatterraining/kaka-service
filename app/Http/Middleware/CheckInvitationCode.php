<?php

namespace App\Http\Middleware;

use Closure;
use App\Data\Sys\ErrorData;
use App\Data\Sys\SendSmsData;
use App\Http\Utils\Session;
use App\Http\Utils\Error;
use App\Data\Activity\ActivityRecordData;
use App\Data\User\UserData;

class CheckInvitationCode
{

    private $session;
    public function __construct(Session $session)
    {
        
        $this->session = $session;
    }
    use Error;

    private $mapArray = [
        'code',
        'activityCode',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * 
     * @author zhoutao
     * @date   2017.8.17
     */
    public function handle($request, Closure $next)
    {
        $requests = $request->all();
        foreach ($this->mapArray as $key) {
            if (array_key_exists($key, $requests)) {
                $code = $requests[$key];
            }
        }
         
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

        //查询是否必须使用邀请码注册
        $userData = new UserData;
        $invArray = $userData->getSysCoinfigReq();
        $need_invitation_code = $invArray['need_invitation_code'];
        //可以不输入邀请码注册 直接过
        if ($need_invitation_code === false && empty($code)) {
            return $next($request);
        }

        //判断邀请码是否正确
        $recordData = new ActivityRecordData();
        
        $userCanActivity = $recordData->canInvitation($code, $this->session->userid);
        
        $appEnv = config('checkVerify.appEnv', null);
        $array = [
            'testing',
            'development',
        ];
        // info('APPENV:'.$appEnv);
        if (in_array($appEnv, $array)) {
            if ($code !== 'KaKamfv5') {
                if ($userCanActivity === false) {
                    $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
                    return response(
                        json_encode(
                            $this->result,
                            JSON_UNESCAPED_UNICODE
                            |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                        )
                    );
                }
                if ($userCanActivity !== true) {
                    $this->Error($userCanActivity);
                    return response(
                        json_encode(
                            $this->result,
                            JSON_UNESCAPED_UNICODE
                            |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                        )
                    );
                }
            }
        } else {
            if ($userCanActivity === false) {
                // info($userCanActivity);
                $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
                return response(
                    json_encode(
                        $this->result,
                        JSON_UNESCAPED_UNICODE
                        |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                    )
                );
            }
            if ($userCanActivity !== true) {
                $this->Error($userCanActivity);
                return response(
                    json_encode(
                        $this->result,
                        JSON_UNESCAPED_UNICODE
                        |JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                    )
                );
            }
        }
        

        return $next($request);
    }
}
