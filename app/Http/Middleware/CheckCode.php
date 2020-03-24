<?php
namespace App\Http\Middleware;

use App\Http\Adapter\Sys\ErrorAdapter;
use App\Http\Utils\Error;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Closure;
use App\Http\Utils\Session;
use App\Data\Auth\WechatMsg;
use App\Data\Auth\UserData;

class CheckCode
{

    use Error;
    private $session;
    private $key = "auth_check_code";
    private $item_key = "auth_check_item";
    private $userid_key = "userid";
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



        //检查是否有验证码字段
        $req_data = $request->all();
        //
        $wechat_msg = new WechatMsg();

          //得到相应的变量


          $user_id = $this->session->userid;
          $user_data = new UserData();
          $user_info = null;
         
        if($user_id==0) {              
              $user_id = $req_data[$this->userid_key];
              $user_info =$user_data->getUser($user_id);
        }else{
            $user_info  = $user_data->getByNo($user_id);
        }

        if ($user_info==null) {
            $this->Error(ErrorData::$USER_NOT_FOUND);

            return $this->result ;
        }

        



          $open_id = $user_info->auth_wechatid;
          $user_name =  $user_info->auth_name;
     


        if($open_id ==null && $open_id == "") {
            return $next($request);  
        }
       
        if(false == array_key_exists($this->key, $req_data)
            && false == array_key_exists($this->item_key, $req_data)
        ) {
            //如果没有，发送验证码      

            $url = $_SERVER["REQUEST_URI"];
            $user_behavior = config("api.".$url); 
            if($user_behavior ==""||$user_behavior==null ) {
                $user_behavior = "重要操作";
            }
            $msg_result = $wechat_msg -> SendAuthCode($open_id, $user_name, $user_behavior);

            //保存当前请求
          

            $wechat_msg -> SaveReq($msg_result->item, $url, $req_data);

            $msg_result->behavior = $user_behavior;

            return   response(
                json_encode(

                    array(
                        "code"=>0,
                        "msg"=>"当前操作需要验证码.",
                        "datetime"=>Date("Y-m-d H:i:s"),
                        "_check_code"=> $msg_result 
                    ),
                    JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK
                )
            );


        }else{

            $auth_check_code = $req_data[$this->key];
            $auth_key_item = $req_data[$this->item_key];
            if(true === $wechat_msg->CheckAuthCode($open_id, $auth_key_item, $auth_check_code)) {           
               
                return $next($request);                
            }



        }
     
  
        



        


    
    }

}