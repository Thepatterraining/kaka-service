<?php 
namespace Cybereits\Modules\KYC\Data;
use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;

class PhoneData extends IMySqlModelFactory {
    protected $modelclass = \Cybereits\Modules\KYC\Model\PhoneInfo::class;
    public function AddPhone($name,$no,$mobile){

        $filter = [
        "mobile"=>$mobile,
	"idno"=>$no,
        ];
        if ($this->CheckIsExists($filter)) {
            return true;//throw new CommonException("该手机已经注册", 80009);
        }

/*
        $filter = [
        "idno"=>$no,
        ];
        if ($this->CheckIsExists($filter)) {
            throw new CommonException("该用户已经注册注册手机", 80010);
        }*/
      $item = $this->NewItem();
      $item->idname = $name;
      $item->idno = $no ; 
      $item->mobile = $mobile ;
      $this->Create($item);
    }
}
