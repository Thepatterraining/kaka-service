<?php
namespace App\Handler;

use App\Data\API\Wechat\Wechat;

class CashRechargeHandler {
  public function notifyrun($data){

    $data = (Object)$data;
    if(trim($data -> cash_recharge_type) =="CRT01"){
      $wechat = new Wechat();
      $openids = [
        "oHGcAwzY5iYIZENNBeMG2MHFYVTw"=>"客服",
        "oHGcAw5NF6WxyWecNMX8IF6ANh0s"=>"郝爷",
        "oHGcAwwOdKApgN1wdzamTnhhN4dA"=>"宏拾",
        "oHGcAw8D8Bq0VkoKbR1OsY-pUrC0"=>"燕姐",
        "oHGcAw_GZ0GZdO0NquOuZ6Iw7Ry0"=>"王德林",
      ];
      $msg_tmpid = "nGp2xuI7tGq0KJiTwE1gODFwwoAwFDxls_5U5e7JmL8";
      $msg_content = [
        "first"=>"", //第一行 
        "keyword1"=>"用户线下充值",//项目描述
        "keyword2"=>"对帐及审批",//工作内容 
        "keyword3"=>"单据尾号".substr( $data->cash_recharge_no, strlen($data->cash_recharge_no)-6).",金额:".$data->cash_recharge_amount,//流程摘要
        "keyword4"=>"无",//要求完成时间
        "keyword5"=>"系统",//发送人
        "remark"=>""//随意写点
      ];
      foreach($openids as $openid=>$name){
        $msg_content["first"]="Hi,${name},有新的业务需要您处理";
        $wechat -> SendMsg($openid,$msg_tmpid,$msg_content);
      }
    }
  }
}
