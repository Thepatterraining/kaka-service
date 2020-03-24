<?php
namespace Cybereits\Modules\KYC\API;
//        Cybereits\Modules\KYC\Cybereits\Modules\KYC\API\CheckIDLomo
use Cybereits\Modules\KYC\API\ICheckID ;

class CheckIDLomo implements ICheckID {

  public function  CheckID ($idno,$name){


      $sign = config("kyc.id_sigin");
      $array = [
          'name'=>$name,
          'id_number'=>$idno,
      ];
      $sign = $this->sign($array, $sign);
      $array['auth_code'] = $sign;
      $url = 'https://apiv2.lomocoin.com/v1/kaka/verify';
      $data = $this->curlGet($url, $array);

      $data = json_decode($data);
      if ($data->status == 200) {
          if ($data->result->status == true) {
              return true;
          } elseif ($data->result->status == false) {
              return false;
          }
      } else {
	  info(json_encode($data));
          return false;
      }
  }

  private function curlGet($url, $_aryData)
  {
      $url = $url . '?' . http_build_query($_aryData);

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

      curl_setopt($curl, CURLOPT_HEADER, 0);

      $data = curl_exec($curl);

      curl_close($curl);

      return $data;
  }

  private function sign($_aryData, $_strSignKey = "")
  {
      // 将KEY添加到合并数据
      $_aryData[] = $_strSignKey;
      sort($_aryData, SORT_STRING);
      // 合并数据
      $sign = implode("_", $_aryData);
      // 将字符串签名，获得签名结果
      $sign = md5($sign);
      return $sign;
  }

}
