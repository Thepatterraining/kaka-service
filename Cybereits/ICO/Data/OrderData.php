<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Data\WaletData;
use cybereits\Modules\ICO\Data\TokenData;
use Illuminate\Support\Facades\DB;
use Cybereits\Modules\COIN\Data\TranDocData;

/**
 * order 的状态变化 (order->status)
 * 0 - 已经登记
 * 1 - 已经审核
 * 2 - 已经接受投资
 * 3 - 准备发币
 * 4 - 开始发币
 * 5 - 发币确认
 * 6 - 申请退币
 * 7 - 收币确认
 * 8 - 开始退币
 * 9 - 发起退币
 * 10 - 退币确认
 *
 * order 的类型 (0 私募 1 早鸟 2 公售 )
 */

class OrderData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\Order::class;


    

    /**
     * 创建订单
     */
    public function CreateOrder($id, $name, $email, $mobile, $commnity, $amount, $address, $wechat)
    {
        $progress = config("ico.progress");
        $scales = config("ico.scale");

        $scale = $scales[ $progress];
        $filter = [
        "email"=>$email,
        "order_type"=>$progress,
        ];
        if ($this->CheckIsExists($filter)) {
            throw new CommonException("每个邮箱只能登记一次,您已经登记.", 80001);
        }
        $filter = [
        "idno"=>$id,
        "order_type"=>$progress,
        ];
        if ($this->CheckIsExists($filter)) {
            throw new CommonException("一个身份证号只能登记一次,您已经登记", 80009);
        }


        $commnity_fac = new CommunityData();
        $commnity_data = $commnity_fac->Get($commnity);
        if ($commnity_data == null) {
            throw new CommonException("未查到社区信息.", 80002);
        }

        $item = $this->NewItem();
        $item -> name = $name;
        $item -> idno = $id;
        $item -> mobile = $mobile;
        $item -> email = $email;
        $item -> community_id = $commnity_data -> id;
        $item -> community_name = $commnity_data -> name;
        $item -> wechat = $wechat ;
        $item -> amount = $amount;
        $item -> address = $address;
        $item -> dealamount = 0;
        $item -> returnamount = 0;
        $item -> index = 0;
        $item -> order_type = $progress;
        $item -> scale = $scale;

        $this->Create($item);
        $item -> index = $item -> id + 350;
        $this->Save($item);
        return $item->index;
    }

    public function AddOrder($name, $amount, $address, $progress)
    {
        $scales = config("ico.scale");
        $scale = $scales[ $progress];
        $item = $this->NewItem();
        $item -> name = $name;
        $item -> idno = "";
        $item -> mobile =  "";
        $item -> email = $name;
        $item -> community_id =1;
        $item -> community_name = "";
        $item -> wechat = "";
        $item -> amount = $amount;
        $item -> address = $address;
        $item -> dealamount = 0;
        $item -> returnamount = 0;
        $item -> index = 0;
        $item -> order_type = $progress;
        $item -> scale = $scale;
        $this -> Create($item);
    }
    public function CheckOrder($email, $address)
    {
        $scales = config("ico.scale");
        $progress = config("ico.progress");
        DB::beginTransaction();
        $filter = [
           "email"=>$email,
           "status"=>0,
           "order_type"=>$progress,
        ];
        $item = $this->GetFirst($filter);
        if ($item == null) {
            throw new CommonException("订单不存在!", 80003);
        }
        $waletFac = new WaletData();
        $waletFac -> CreateWalet($address, "早鸟");
        $scale = $scales[$item->order_type];
        $item->status = 1;
        $item->payaddress = $address;
        $item->scale=$scale;

        $item->save();
        DB::commit();
        return $item ;
    }
    public function GetOrder($email, $ordertype =1)
    {
        $filter = [
            "email"=>$email,
            "order_type"=>$ordertype,
        ];
        $item = $this->GetFirst($filter);
        if ($item == null) {
            throw new CommonException("订单不存在!", 80003);
        }
        return $item;
    }

    public function AcceptOrder($email, $amount)
    {
        $progress = config("ico.progress");
        DB::beginTransaction();
        $filter = [
         "email"=>$email,
         "status"=>1,
         "order_type"=>$progress,
        ];
        $item = $this->GetFirst($filter);
        if ($item ==null) {
            throw new CommonException("订单不存在!", 80003);
        }
        $item -> accept_amount = $amount ;
        $item -> status = 2;
        $item -> save();
        DB::commit();
        return $item ;
    }


    public function GetWaletToDiscoin($count)
    {
        $type = config("ico.send_tye");
        $filter = [
            "status"=>2,
            "order_type"=>$type,
        ];
        $queryResult  =  $this->queryWithPaging($filter, $count, 1);
        $items = $queryResult ["items"];
        $result = [];
        DB::beginTransaction();
        foreach ($items as $item) {
            $r_item =  (Object)[
                "address"=>$item->address,
                "amount"=>$item->scale * $item->accept_amount,
            ];
	    if($item->scale === 0)
	    {
	      $r_item->amount = $item->accept_amount;
	    }
	    $result []=$r_item;	
            $item->status = 3;
            $item->save();
            info("return address ".$item->address." to discoin.");
        }
        DB::commit();
        return $result;
    }

    public function SuccessWaletDiscoin($walet)
    {
    }
    public function SaveOrdersDistribution($address)
    {
        return$this->_updateOrderStatus($address, 3, 4);
    }
    public function SaveOrdersSccess($address)
    {
        return $this->_updateOrderStatus($address, 4, 5);
    }
    public function GetSendedAddress()
    {
        $type = config("ico.send_tye");
        $filter = [
        "order_type"=>$type,
        "status"=>4];
    
        $items = $this->Query($filter);
        $result = [];
        foreach ($items as $item) {
            $result[] = $item->address;
        }
        return $result ;
    }
    private function _updateOrderStatus($address, $old, $new, $type = 0)
    {
        if ($type ==0) {
            $type = config("ico.send_tye");
        }
        $items = [];
        if(is_array($address)==false){
            $address = [$address];
        }
        foreach ($address as $add) {
            $filter = [
                "address"=>$add,
                "status"=>$old,
                "order_type"=>$type,
            ];
            $item = $this->GetFirst($filter);
            if ($item!=null) {
                $item->status = $new;
                info("Update Order State ".$item->address." ".$old."->".$new);
                $item->save();
                $items[]=["address"=>$item->address,"success"=>true];
            } else {
                $items[]=["address"=>$add,"success"=>false];
            }
        }
        return $items;
    }


    private function _updateOrderStatusById($ids, $old, $new, $type = 0)
    {
        if ($type ==0) {
            $type = config("ico.send_tye");
        }
        $items = [];
        if(is_array($ids)==false){
            $ids = [$ids];
        }
        foreach ($ids as $id) {
            $filter = [
                "id"=>$id,
                "status"=>$old,
                "order_type"=>$type,
            ];
            $item = $this->GetFirst($filter);
            if ($item!=null) {
                $item->status = $new;
                info("Update Order State ".$item->address." ".$old."->".$new);
                $item->save();
                $items[]=["address"=>$item->address,"id"=>$id,"success"=>true];
            } else {
                $items[]=["id"=>$id,"success"=>false];
            }
        }
        return $items;
    }
    public function GetReturns($count)
    {
        $sql = "select name,mobile,email,idno,ico_order.address reg_address, ico_order.payaddress sys_address, ico_order.amount reg_amount,ico_order.accept_amount ,coin_sys_address_amount.address_amount receive_amount,coin_sys_address_amount.address_amount - ico_order.accept_amount return_amount  from ico_order,coin_sys_address_amount where ico_order.payaddress = coin_sys_address_amount.address and ico_order.order_type = 1 and coin_sys_address_amount.address_amount > ico_order.accept_amount and ico_order.address not in (select address from coin_sys_transdoc) ";
        if (is_numeric($count) && $count > 0) {
            $sql = $sql . " limit ".$count ;
        }
        $items = DB::select($sql);
        return $items;
    }
    public function GetUnOrders()
    {
        $filter = [
        "status"=>[">=",3],
        "status"=>["<",5],
        ];
        return $this->Query($filter);
    }
    


    /**
     * 申请退币
     */
    public function RequireRevoke($email, $order_type=1)
    {
        $filter = [
            "email"=> $email,
            "order_type"=>$order_type,
//            "status"=>5
        ];

        $doc = $this->GetFirst($filter);
        if ($doc == null) {
            throw new CommonException("订单不存在!", 80003);
        }
        $doc -> status = 6;
        $doc->save();
        return $doc ;
    }
    
    /**
     * 收到退币信息
     */

    public function AcceptRevoke($address)
    {
        $item = $this-> _updateOrderStatus($address, 6, 7, 1);
    }
    

    /**
     * 开始退币
     */
    public function BeginRevoke($address)
    {
        $item = $this-> _updateOrderStatus($address, 7, 8, 1);
    }

    /**
     * 发起退币交易
     */
    public function BeginRevokeSend($address)
    {
       return $this-> _updateOrderStatusById($address, 8, 9, 1);
    }

    /**
     * 退币成功确认
     */

    public function SuccessRevoke($address)
    {
      return  $this-> _updateOrderStatusById($address, 9, 10, 1);
    }

    /**
     * 得到要退币的信息
     */
    public function GetRevokeDocs(){

        $filter = [
            "status"=>7
        ];
        $items = $this->Query($filter);
        $result = [];
        foreach($items as $item){
            $this->BeginRevoke($item->address);

            $result []=[
                "id"=>$item->id,
                "address"=>$item->address,
                "amount"=>$item->accept_amount,
                "name"=>$item->name,
                "email"=>$item->email,
                "mobile"=>$item->mobile,
                "coin_type"=>"ETH"
            ];
        }
        return $result ;
    }
}
