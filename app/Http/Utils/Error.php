<?php
namespace App\Http\Utils;

use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use App\Data\Sys\LogData;

trait Error
{

    public function Error($code)
    {

        $errorData = new ErrorData();
        $errorAdapter = new ErrorAdapter();
        $item = $errorData->getErrorByCode($code);
        
        if ($item!=null) {
                $error = $errorAdapter->getFromModel($item, false);
                $error["datetime"]=Date("Y-m-d H:i:s");
                $this->result = $error;
        } else {
            $this->result = array(
                "code" => $code,
                "msg" => "错误未在系统中定义",
                   "datetime"=>Date("Y-m-d H:i:s")
            );
        }

        $log = new LogData();
        $item = $log->newitem();
        $item -> error_code = $code;

        if (array_key_exists("REQUEST_URI", $_SERVER)) {
            $item -> url = $_SERVER["REQUEST_URI"];
        } else {
            $item->url = "";
        }
        $log->create($item);

        
    }
}
