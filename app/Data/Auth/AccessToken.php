<?php
namespace App\Data\Auth;

use Illuminate\Support\Facades\Redis;

class AccessToken
{
    
    
    /**
     *
     *
     */
    public function create_guid($namespace = 'KKService')
    {
        static $guid = '';
        $uid = uniqid("", true);
        $data = $namespace;
        $keys = [
        'REQUEST_TIME',
        'HTTP_USER_AGENT',
        'LOCAL_ADDR',
        'LOCAL_PORT',
        'REMOTE_ADDR',
        'REMOTE_PORT'
        ];
        foreach ($keys as $key) {
            if (array_key_exists($key, $_SERVER)===true) {
                $data .= $_SERVER[$key];
            }
        }
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = '' .
        substr($hash, 0, 8) .
        '-' .
        substr($hash, 8, 4) .
        '-' .
        substr($hash, 12, 4) .
        '-' .
        substr($hash, 16, 4) .
        '-' .
        substr($hash, 20, 12) .
        '';
        return $guid;
    }

    /**
     * 更新存储为appid, appname, userid
     *
     * @param  $app 应用信息
     * @param  $timeout 过期时间
     * @author zhoutao
     * @date   2017.11.7
     */
    public function getAccessToken($app = [], $timeout = 7200)
    {
        $tokenid=$this->create_guid();
        $app = json_encode($app);
        Redis::command('set', [$tokenid,$app]);
        Redis::command('expire', [$tokenid,$timeout]);

        return $tokenid;
    }
    /**
     * 查询出来app信息
     *
     * @author zhoutao
     * @date   2017.11.7
     */
    public function checkAccessToken($tokenid, $timeout = 7200)
    {
        
        $app = Redis::command('get', [$tokenid]);
        if ($app != null) {
             Redis::command('set', [$tokenid,$app]);
             Redis::command('expire', [$tokenid,$timeout]);
             $app = json_decode($app, true);
             return $app;
        }
        return null;
    }
    
    
    
    
    private static $ADMIN_PRE = "admin_";
    private static $ADMIN_USERPRE = "admin_user_";
    
    public function getAdminAccessToken($useid = 0, $timeout = 7200)
    {
        

        $tokenid = $this->create_guid();
        $key= AccessToken::$ADMIN_PRE.$tokenid;
        Redis::command('set', [$key,$useid]);
        Redis::command('expire', [$key,$timeout]);
        return $tokenid;
    }
    
    /**
     * 查询出来json 更新其中的用户id
     *
     * @author zhoutao
     * @date   2017.11.7
     */
    public function updateAccessToken($tokenid, $userid, $timeout = 7200)
    {
        
        $tmp = Redis::command('get', [$tokenid]);
        if ($tmp != null) {
            $app = json_decode($tmp, true);
            $app['userid'] = $userid;
            $app = json_encode($app);
            Redis::command('set', [$tokenid,$app]);
            Redis::command('expire', [$tokenid,$timeout]);
            return $userid;
        }
        return null;
    }
    
    public function authLogin($tokenid, $userid, $timeout = 7200)
    {
        Redis::command('set', [$tokenid,$userid]);
        Redis::command('expire', [$tokenid,$timeout]);
        $ob = $this->checkAccessToken($userid);
        if ($ob != null) {
            Redis::command('set', [$tokenid,-1]);
            Redis::command('expire', [$tokenid,$timeout]);
        } else {
            Redis::command('set', [$userid,$tokenid]);
            Redis::command('expire', [$userid,$timeout]);
        }
    }



    /**
     *
     *
     *
     *
     *
     */
    public function authAdminLogin($tokenid, $userid, $timeout = 7200)
    {

        $key = AccessToken::$ADMIN_PRE.$tokenid;
        $userkey = AccessToken::$ADMIN_USERPRE.$userid;

        // save user info
        Redis::command('set', [$key,$userid]);
        Redis::command('expire', [$key,$timeout]);


        // get last login
        $ob = $this->checkAccessToken($userkey);
        if ($ob != null) {
            Redis::command('set', [$ob,-1]);
            Redis::command('expire', [$key,$timeout]);
        } else {
            Redis::command('set', [$userkey,$key]);
            Redis::command('expire', [$userkey,$timeout]);
        }
    }


    public function checkAdminAccessToken($tokenid, $timeout = 7200)
    {
        
        $key =  AccessToken::$ADMIN_PRE.$tokenid;
        $userid = Redis::command('get', [$key]);
        if ($userid != null) {
            
            return $userid;
        }
        return null;
    }

    /**
     * 存验证码redis
     *
     * @param  $key 
     * @param  $value
     * @param  $timeout 
     * @author zhoutao
     * @date   2017.11.15
     */
    public function setVerfiy($key, $value, $timeout)
    {
        Redis::command('set', [$key,$value]);
        Redis::command('expire', [$key,$timeout]);
    }
}
