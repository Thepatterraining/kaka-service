<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Utils\Error;
use App\Http\Utils\Session;
use Validator;
use iscms\Alisms\SendsmsPusher as Sms;
use App\Http\Utils\RaiseEvent;
use App\Data\Monitor\DebugInfoData;

abstract class Controller extends BaseController
{
    use  ValidatesRequests;
    use Error;
    use RaiseEvent;
    protected $result ;
    protected $input;
    protected $request;
    protected $sms;
    protected $requireAarray ;
    protected $requireValid ;
    protected $session ;
    private $debugData;
    private $debuglog;
    protected $json = true;
    function array_remove($data, $key)
    {
        if (!array_key_exists($key, $data)) {
            return $data;
        }
        $keys = array_keys($data);
        $index = array_search($key, $keys);
        if ($index !== false) {
            array_splice($data, $index, 1);
        }
        return $data;
    }

    public function __construct(Session $session)
    { 
        $this->session = $session;
    }
    
    public function __invoke(Request $request, Sms $sms, ...$params)
    {
      
        $lgall = config('app.logall');
        if ($lgall ===true) {
            $debugData = new DebugInfoData();
            $debuglog =$debugData->newitem();
            if (array_key_exists('REQUEST_URI', $_SERVER)===true) {
                    $debuglog->url = $_SERVER["REQUEST_URI"];
            }
           
            $debuglog ->token = $this->session->token;

            

            $logArray = $request->all();
           
            $logArray =  $this->array_remove($logArray, 'pwd');
            $logArray =  $this->array_remove($logArray, 'paypwd');
            $debuglog ->req = json_encode($logArray, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
          
            $debugData->create($debuglog);
        }
     
        $this->request = $request;
        $this->sms = $sms;
        if ($this->validateArray!=null
            && count($this->validateArray)>0
        ) {
            $validator = Validator::make(
                $request->all(),
                $this->validateArray,
                $this->validateMsg
            );
            if ($validator->fails()) {
                if ($this->session->error!=null) {
                    $this->Error($this->session->error);
                } else {    
                    $this->result = [
                        "code" => 880001,
                        "msg" => $validator->errors()->first(),
                        "datetime"=>Date("Y-m-d H:i:s")
                    ];
                }
                return json_encode($this->result, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
            }
        }
        
        
        try {
            $this->run($params);
            $this->RaisEvent();
            $this->RaisQueueEvent();
        } catch (Exception $e) {
            $this->result = [
                "code" => 99999,
                "msg" =>  "出现错误,请稍后再试",
                "datetime"=>Date("Y-m-d H:i:s")
            ];

        }

        if ($lgall==true) {
            $debuglog->res = json_encode($this->result, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            $debuglog->save();
        }
        if ($this->json) {
            return json_encode($this->result, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        } else {
            return $this->result;
        }
    }
    
    abstract protected function run();
    
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


    protected function getXMLPost()
    {
    }

    protected function object_array($array) 
    {  
        if(is_object($array)) {  
            $array = (array)$array;  
        } if(is_array($array)) {  
            foreach($array as $key=>$value) {  
                $array[$key] = object_array($value);  
            }  
        }  
        return $array;  
    }  

    protected function Dump($result = null)
    {
         $return_array  = $result ;
        $this->result = array(
        "code"=>0,
        "msg"=>"调用成功.",
        "datetime"=>Date("Y-m-d H:i:s"),
        "data"=>$return_array
        );
    }
}
