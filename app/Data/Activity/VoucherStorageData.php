<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Voucher\VoucherFactory;
// use App\Data\Notify\INotifyDefault;

class VoucherStorageData extends IDatafactory //implements INotifyDefault
{
    protected $no = 'vaucherstorage_no';

    protected $modelclass = 'App\Model\Activity\VoucherStorage';

    const UN_USE_STATUS = 'VOUS00';
    const USE_STATUS = 'VOUS01';
    const OVERDUE_STATUS = 'VOUS02';

    const VOUCHER_EVENT_TYPE = 'NewUser_Voucher_Check';

    /**
     * 添加现金券使用表
     *
     * @param   $no 单据号
     * @param   $voucherNo 现金券编号
     * @param   $activiNo 活动编号
     * @param   $userid 用户id
     * @param   $outtime 过期时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addStorage($no, $voucherNo, $activiNo, $userid, $outtime)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('VCS');

        $model = $this->newitem();
        $model->vaucherstorage_no = $no;
        $model->vaucherstorage_voucherno = $voucherNo;
        $model->vaucherstorage_activity = $activiNo;
        $model->voucherstorage_userid = $userid;
        $model->voucherstorage_storagetime = date('Y-m-d H:i:s');
        $model->voucherstorage_status = 'VOUS00';
        $model->voucherstorage_outtime = date('Y-m-d H:i:s', $outtime);
        return $model->save();
    }

    /**
     * 查询现金券信息
     *
     * @param   $voucherNo 现金券号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getStorage($voucherNo,$userid=null)
    {
        $where['vaucherstorage_voucherno'] = $voucherNo;
        $where['voucherstorage_status'] = 'VOUS00';
        if($userid ==null ) {
            $where['voucherstorage_userid'] = $this->session->userid;
        } else { 
               $where['voucherstorage_userid'] =$userid;
        }
        return $this->find($where);
    }

    /**
     * 查询现金券信息
     *
     * @param   $No storage no
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getStorageInfo($No,$userid=null)
    {
        $where['vaucherstorage_no'] = $No;
        $where['voucherstorage_status'] = 'VOUS00';
        if($userid ==null ) {
            $where['voucherstorage_userid'] = $this->session->userid;
        } else { 
               $where['voucherstorage_userid'] =$userid;
        }
        return $this->find($where);
    }

    /**
     * 查现金券信息
     *
     * @author  zhoutao
     * @date    2017.03.23
     * @version 0.2 增加啦对现金券的排序
     * @return  array
     */
    public function getList($userid = null)
    {
        $model = $this->newitem();
        $where['voucherstorage_status'] = 'VOUS00';

        if($userid ==null ) {
            $where['voucherstorage_userid'] = $this->session->userid;
        } else { 
               $where['voucherstorage_userid'] =$userid;
        }
        $voucherList = $model::where($where)->get();

        if ($voucherList->isEmpty()) {
            return [];
        }

        $data = new VoucherInfoData();
        foreach ($voucherList as $k => $v) {
            $whereInfo['vaucher_no'] = $v->vaucherstorage_voucherno;
            $item[$k] = $data->find($whereInfo);
            $item[$k]['vaucher_no'] = $v->vaucherstorage_no;
        }

        //对现金券进行排序
        foreach ($item as $k => $v) {
            $val1[$k] = $v['voucher_val1'];
        }
        array_multisort($val1, SORT_ASC, $item);

        return $item;
    }

    /**
     * 查现金券信息
     *
     * @author  zhoutao
     * @date    2017.03.23
     * @version 0.2 增加啦对现金券的排序
     * @return  array
     */
    public function getVoucherNos($userid = null)
    {
        $model = $this->newitem();
        $where['voucherstorage_status'] = 'VOUS00';
        if($userid ==null ) {
            $where['voucherstorage_userid'] = $this->session->userid;
        } else { 
               $where['voucherstorage_userid'] =$userid;
        }
        $voucherList = $model::where($where)->get();

        if ($voucherList->isEmpty()) {
            return [];
        }

        return $voucherList;
    }

    /**
     * 更新状态
     *
     * @param   $status 状态
     * @param   $voucherNo 现金券号
     * @param   $jobNo 关联单据号
     * @author  zhoutao
     * @version 0.1
     */
    public function saveStatus($status, $voucherNo, $jobNo, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $storageInfo = $this->getStorage($voucherNo);
        $storageInfo->voucherstorage_status = $status;
        $storageInfo->voucherstorage_jobno = $jobNo;
        $storageInfo->voucherstorage_usetime = $date;
        return $storageInfo->save();
    }

    /**
     * 根据单据号更新状态
     *
     * @param   $status 状态
     * @param   $no 单据号
     * @param   $jobNo 关联单据号
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function saveVoucherStorageStatus($status, $no, $jobNo, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $storageInfo = $this->getStorageInfo($no);
        $storageInfo->voucherstorage_status = $status;
        $storageInfo->voucherstorage_jobno = $jobNo;
        $storageInfo->voucherstorage_usetime = $date;
        return $storageInfo->save();
    }


    /**
     * 查询用户代金券信息 因为需要三个状态的数量，所以单开此接口
     *
     * @param   $filter where条件
     * @param   $pageSize
     * @param   $pageIndex
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.24
     */
    public function getUserVoucher($filter, $pageSize, $pageIndex)
    {
        $classname = $this->newitem();
        $tmp = null;
        if (count($filter)) {
            $tmp = $classname->where($filter);
        }
        $result = array();
        $result['totalSize1'] = $classname::where('voucherstorage_status', 'VOUS00')->where('voucherstorage_userid', $this->session->userid)->count();
        $result['totalSize2'] = $classname::where('voucherstorage_status', 'VOUS01')->where('voucherstorage_userid', $this->session->userid)->count();
        $result['totalSize3'] = $classname::where('voucherstorage_status', 'VOUS02')->where('voucherstorage_userid', $this->session->userid)->count();
        $tmp = $tmp->orderBy('id', 'desc');
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        return $result;
    }

    /**
     * 返回现金券减少金额
     *
     * @param   $_voucherNo
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加查询金额是否可以使用，不可以使用返回现金券减少0
     * @param   $totalMoney 总金额
     * @author  zhoutao
     * @date    2017.10.20
     */
    public function getVoucherReduceCash($_voucherNo, $totalMoney)
    {
        if (empty($_voucherNo)) {
            return 0;
        }
        $info = $this->getStorageInfo($_voucherNo);
        if (empty($info)) {
            return 0;
        }
        $voucherNo = $info->vaucherstorage_voucherno;
        $voucherData = new VoucherInfoData();
        $voucherInfo = $voucherData->getByNo($voucherNo);
        if (empty($voucherInfo)) {
            return 0;
        }
        $voucherFac = new VoucherFactory;
        $usingVoucher = $voucherFac->createVoucherModelUseing($voucherInfo);
        if ($usingVoucher->CanUsingVoucherBuy($_voucherNo, $totalMoney, $this->session->userid) === false) {
            return 0;
        }
        return $voucherInfo->voucher_val2;
    }

    /**
     * 获取用户一段时间内使用的优惠券
     *
     * @param   $userid 用户id
     * @param   $start 开始时间
     * @param   $end   结束时间
     * @author  liu
     * @version 0.1
     */
    public function getVoucherDaily($userId,$start,$end)
    {
        $model=$this->newitem();
        $result=$model->where('voucherstorage_userid', $userId)
            ->whereBetween('voucherstorage_usetime', [$start,$end])
            ->where('voucherstorage_jobno', '<>', "")
            ->get();
        return $result;
    }

    /**
     * 获取用户未使用的优惠券
     *
     * @param   $userId 用户id
     * @author  liu
     * @version 0.1
     */
    public function getUnuseVoucher($userId)
    {
        $model=$this->newitem();
        $result=$model->where('voucherstorage_userid', $userId)
            ->where('voucherstorage_status', 'VOUS00')
            ->get();
        return $result;
    }

     /**
      * 查询用户可用优惠券的数量
      *
      * @author zhoutao
      */
    public function getUserVouchercount()
    {
        $classname = $this->modelclass;
        return $classname::where('voucherstorage_status', 'VOUS00')->where('voucherstorage_userid', $this->session->userid)->count();
    }

    public function getVoucherToday($start,$end)
    {
        $model=$this->newitem();
        return $model->whereBetween('voucherstorage_usetime', [$start,$end])
            ->where('voucherstorage_jobno', '<>', "")
            ->get();
    }

     /**
      * 优惠券过期
      */
    public function overdue()
    {
        $uservouchers = $this->getUnuseVoucher($this->session->userid);
        if (!$uservouchers->isEmpty()) {
            foreach ($uservouchers as $voucher) {
                $outTime = $voucher->voucherstorage_outtime;
                if ($outTime <= date('Y-m-d H:i:s')) {
                    $voucher->voucherstorage_status = self::OVERDUE_STATUS;
                    $this->save($voucher);
                }
            }
        }
    }

     /**
      * 根据单据号查找对应优惠券
      *
      * @param   $no 单据号
      * @author  liu
      * @version 0.1
      */
    public function getVoucherByToNo($no)
    {
        $model=$this->newitem();
        $result=$model->where('voucherstorage_jobno', $no)->get();
        return $result;
    }

    // public function notifycreateddefaultrun($data){}

    // /**
    //  * 收回项目后发卷
    //  * @param $data
    //  * @author zhoutao
    //  * @date 2017.11.11
    //  */
    // public function notifysaveddefaultrun($data){
    //     $voucherData = new VoucherStorageData();
    //     $voucherInfoData = new VoucherInfoData();

    //     $userid = $data['lending_lenduser'];
    //     $voucherNo = $data['params']['voucherNo'];
    //     $voucherInfo = $voucherInfoData->getByNo($voucherNo);
    //     if (!empty($voucherInfo)) {
    //         $timespan = $voucherInfo->voucher_timespan;
    //         $outtime = date('U') + $timespan;
    //         $voucherData->addStorage('', $voucherNo, '', $userid, $outtime);
    //     }

    //     //通知用户
    //     $this->AddEvent(self::VOUCHER_EVENT_TYPE, $userid, $voucherNo);
    // }
    // public function notifydeleteddefaultrun($data){}
}
