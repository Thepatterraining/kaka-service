<?php
namespace Cybereits\Http;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Cybereits\Common\Event\RaiseEvent;
use Cybereits\Common\CommonException;
use Validator;

abstract class IController extends BaseController
{
    use  ValidatesRequests;
    use RaiseEvent;
    protected $result ;
    protected $input;
    protected $request;
    protected $sms;
    protected $requireAarray ;
    protected $requireValid ;
    protected $session ;
    protected $json = true;
    public function __invoke(Request $request, ...$params)
    {
        $this->request = $request;
        try {
            $this->run($params);
        } catch (CommonException $ex) {
            $this->result =[
                "code" => $ex -> Code,
                "msg"=> $ex -> Msg,
                "datetime"=>Date("Y-m-d H:i:s"),
            ];
        } catch (Exception $e) {
            $this->result = [
                "code" => 99999,
                "msg" =>  "出现错误,请稍后再试",
                "datetime"=>Date("Y-m-d H:i:s")
            ];
        }
        
        if ($this->json) {
            return json_encode($this->result, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        } else {

           return $this->GetResult();
        }
    }

    function GetResult(){
        dump("sdda");
        return $this->result;
    }


    public function __destruct()
    {
        $this->RaiseQueueEvent();
    }
    
    abstract protected function run($params);
    
    protected function Success($result = null)
    {
        $return_array  = $result ;
        $this->result = array(
        "code"=>0,
        "msg"=>"调用成功.",
        "datetime"=>Date("Y-m-d H:i:s"),
        "data"=>$return_array
        );
    }
    
    protected $validateArray;
    
    protected $validateMsg;
}
