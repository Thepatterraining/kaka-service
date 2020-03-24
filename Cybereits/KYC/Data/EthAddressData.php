<?php 
namespace Cybereits\Modules\KYC\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;

class EthAddressData extends IMySqlModelFactory
{
    protected $modelclass = "\Cybereits\Modules\KYC\Model\EthAddress";
    public function AddAddress($name, $idno, $address)
    {
        $filter = [
        "address"=>$address,
	"idno"=>$idno,
        ];
        if ($this->CheckIsExists($filter)) {
		return true;
            //throw new CommonException("该地址已经注册", 80007);
        }

/*
        $filter = [
        "idno"=>$idno,
        ];
        if ($this->CheckIsExists($filter)) {
            throw new CommonException("该用户已经注册地址", 80008);
        }

*/
        $item = $this->NewItem();
        $item->name = $name;
        $item ->idno = $idno;
        $item->address = $address;
        $this->Create($item);
    }
}
