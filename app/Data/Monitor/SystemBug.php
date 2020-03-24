<?php 
namespace App\Data\Monitor;
use App\Data\IDataFactory ;
/**
 * 系统错误日志
 * 这回是真错误
 * 
 * @author  老拐 <geyunfei@kakamf.com>
 * @version Release 2.3.*
 * @date    2017-11-20
 */

class SystemBug extends IDataFactory
{
    protected $modelclass  = "App\Model\Monitor\ErrorInfo";

    /**
     * 添加错误信息
     * 
     * @param guid   $token token
     * @param string $url   url
     * @param string $dump  dump
     * 
     * @return null 
     */
    public function addBug($token,$url,$dump)
    {
        $item = $this-> newitem();
        $item -> dumpinfo =$dump;
        $item -> token = $token;
        $item -> url = $url;
        $this -> create($item);
    }
}