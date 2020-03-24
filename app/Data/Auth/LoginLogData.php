<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class LoginLogData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\LoginLog';

    public function addLog()
    {
        $log = $this->newitem();
        $log->auth_user_id = $this->session->userid;
        $log->login_token = $this->session->token;
        $log->login_type = "UL01";
        $log->login_time = date('Y-m-d H:i:s');
        if (array_key_exists("REMOTE_ADDR", $_SERVER)==false) {
            $_SERVER['REMOTE_ADDR']="UNKNOWN";
        }
        $log->login_add = $_SERVER['REMOTE_ADDR'];
        ;
        $log->login_mac = $_SERVER['REMOTE_ADDR'];
        $log->login_ip = $_SERVER['REMOTE_ADDR'];
        $this->create($log);
    }
}
