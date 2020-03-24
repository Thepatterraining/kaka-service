<?php 
namespace Cybereits\Modules\KYC\Data;
use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
 
class EmailData extends IMySqlModelFactory {
    protected $modelclass = "\Cybereits\Modules\KYC\Model\Email";
    public function AddEmail ($name,$idno,$email){
        $filter = [
            "email"=>$email,
        ];
        if( $this->CheckIsExists($filter)){
           // throw new CommonException("该邮件已经注册", 80004);
           
        }

        $filter = [
            "idno"=>$idno,
        ];
        if( $this->CheckIsExists($filter)){
            //throw new CommonException("该用户已经注册邮件", 80005);
        }
        $item = $this->NewItem();
        $item->name = $name;
        $item ->idno = $idno;
        $item->email = $email;
        $this->Create($item);

    }
}
