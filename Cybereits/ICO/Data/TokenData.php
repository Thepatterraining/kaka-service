<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
use Cybereits\Common\Utils\RandomMaker;

class TokenData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\Token::class;

    public function CreateToken($email, $address)
    {
        $len = 8;

        $token = RandomMaker::getRandomString($len);
        $array = [
          "token"=>$token
        ];
        while ($this->CheckIsExists($array)==true) {
            $array = [
              "token"=>$token
            ];
        }
	$now = date("Y-m-d H:i:s");
	$time =  date_create($now);
	date_add($time,date_interval_create_from_date_string("12 hours"));
        $time = date_format($time,'Y-m-d H:i:s');
	$item = $this->NewItem();
        $item -> address = $address;
        $item -> deadline  = '2018-1-22 00:00:00';
        $item -> token = $token;
        $this->Create($item);
        return $token;
    }

    public function GetInfo($token)
    {
        $deadline = date("Y-m-d H:i:s");
        $array = [
          'deadline'=>['>',$deadline],
          'token'=>$token,
        ];
        $item = $this->GetFirst($array);

        if ($item ==null ) {
            throw new CommonException("连接已经失效", 800020);
        }
        return $item;
    }
}
