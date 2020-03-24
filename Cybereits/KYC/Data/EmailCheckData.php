<?php
namespace Cybereits\Modules\KYC\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
class EmailCheckData extends IMySqlModelFactory
{
    protected $modelclass = "\Cybereits\Modules\KYC\Model\EmailCheck";

    //              RequireEmailCheck
    public function RequireEmailCheck($email)
    {
        $item = $this->NewItem();
        $item -> email = $email ;
        $item -> checkcode = $this->_getCheckCode();
        $item -> verify = false ;
        $item -> timeout = Date('y-m-d h:i:s');
        $item -> sendcount = 1 ;
        $this->Create($item);
    }


    public function CheckEmail($email, $code)
    {
        $filter =[
        "email"=>$email,
        "checkcode"=>$code
        ];
        $item = $this->GetFirst($filter);
        if ($item!=null) {
            $item ->verify = true;
            $this->Save($item);
            return true;
        } else {
            throw new CommonException("邮件验证不匹配", 80001);
        }
        return false;
    }

    private function _getCheckCode()
    {
//	return "123456";
        $chars = array_merge(range(1, 9));
        $str = '';
        $len = 6;
        $arr_len = count($chars)-1;
        if ($arr_len > 0 && $len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $str .= $chars[mt_rand(0, $arr_len)];
            }
        }
        return $str;
    }

}
