<?php
namespace App\Http\Controllers\CheckAuth;
use App\Http\Controllers\Controller ;
use App\Data\Auth\WechatMsg;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Route;


class WechatCheckCode extends Controller
{
    private $key = "auth_check_code";
    private $item_key = "auth_check_item";
    protected $validateArray=[
        "auth_check_code"=>"required",
        "auth_check_item"=>"required", 
    ];

    protected $validateMsg = [
        "auth_check_code.required"=>"请输入验证码!",
        "auth_check_item.required"=>"请输入验证序号!",
      
    ];

   
    public function run() //step 3
    {
        $req_data = $this->request->all();
        //取出保存的请求
        $wechat_msg = new WechatMsg;
        $auth_check_code = $req_data[$this->key];
        $auth_key_item = $req_data[$this->item_key];
        if(true === $wechat_msg->CheckAuthCode($auth_key_item, $auth_check_code)) {   
            $save_req = $wechat_msg->GetReq($auth_key_item);
            if($save_req != null) {
                $items= Route::getRoutes();
                foreach($items->get() as $routerIns){
                    if("/".$routerIns->uri ==$save_req["url"]) {
                        $ctrl=$routerIns->getController();
                        $this->request->merge(
                            $save_req[
                            "data"
                            ]
                        ); 
                        $ctrl->__invoke($this->request, $this->sms);
                        $this->result =  $ctrl->result;
                        $this->result["_callback_url"]=$routerIns->uri;
                        return ;
                    }
                }

            } else {

                //验证码超时

                $this->Error(ErrorData::AUTH_CODE_TIMEOUT);

            }

        } else {
            //验证码错误 
            
            $this->Error(ErrorData::AUTH_CODE_ERROR);
        }
    }
}