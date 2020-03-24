<?php
namespace App\Http\Utils;
use App\Http\Utils\RaiseEvent;

/**
 * 本拐查烦了
 * 妈的全加上！
 * Sep 25th,2017 
 * Fuck SB geyunfei before Sep 25th,2017
 *
 * @author  老拐 <geyunfei@kakamf.com>
 * @version Release <2.3.2>
 * @date    2017-11-20
 * 在这里发事件，哈哈
 **/
class Session
{

    use RaiseEvent ;
    public $token ="";
    public $userid=0 ;
    public $error;
    public $evts = array();
    public $event=array() ;
    public $productFreezettime;
    public $user_name = "";
    public $user_openid = "";
    public $user_email = "";
    public $user_mobile = "";
    public $appid = '';
    public $appName = '';
    public $appKey = '';
 
    /**
     * 析构
     */
    public function __destruct()
    { 
        //  dump(get_class($this));
        //  
     
    }
}
