<?php
namespace Cybereits\Modules\KYC\Data;

use Cybereits\Common\DAL\IMySqlModelFactory;
use Illuminate\Support\Facades\DB;
use Cybereits\Modules\KYC\APIFactory;
use Cybereits\Common\CommonException;


class IDInfoZhData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\KYC\Model\IDInfoZh::class;




    public function AddIdInfo($name, $idno)
    {


      
        $apiFac = new APIFactory ;
        $isExits = $this->CheckIsExists([
            "idno" => $idno,
            "name" => $name,
          ]);
        if ($isExits) {
            return true;//throw new CommonException("该用户已经实名登记！", 80003);
        }
        $checkID =  $apiFac -> CreateCheckIDLogic();
        $queryInfo = $apiFac -> CreateQueryInfoLogic();
        if ($checkID -> CheckID($idno,$name)) {
          // 以后挪到其他地方 ：）
            $item = $this->NewItem();
            $item -> name = $name;
            $item -> idno = $idno;
            // $info = $queryInfo -> QueryIDInfo($idno);
            // if($info != null ){
            //   $item-> province = $info->province;
            //   $item -> city = $info -> city;
            //   $item ->town = $info->town;
            //   $item -> area = $info -> area;
            //   $birth = date_parse_from_format("Y年n月j日",$info->birth);
            //   $birth_data = $birth["year"]."-".$birth["month"]."-".$birth["day"];
            //   $item -> birth = $birth_data;
            //   $item -> sex = $info -> sex == "男" ? 1 : 2 ;
            // }
            $this->Create($item);
        }else {
            throw new CommonException("身份证与姓名不一致",800002);
        }
        return $item;
   }

   
}
