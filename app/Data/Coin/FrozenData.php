<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Data\User\CoinJournalData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Support\Facades\DB;

class FrozenData extends IDatafactory
{

    protected $no = 'frozen_no';

    protected $modelclass = 'App\Model\Coin\Frozen';

    const COUPONS_TYPE = 'FT01'; //优惠券冻结
    const PRODUCT_TYPE = 'FT02'; //产品冻结
    const LENDING_DOC_TYPE = 'FT03'; //拆借冻结

    const FROZEN_STATUS = 'FS01';
    const UNFROZEN_STATUS = 'FS02';

    /**
     * 代币冻结表添加信息
     *
     * @param   $coinType 代币类型
     * @param   $coinId 代币账户id
     * @param   $userId 用户id
     * @param   $jobNo 关联单据号
     * @param   $date 日期
     * @param   string                $type   类型
     * @param   string                $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function add($coinType, $coinId, $userId, $jobNo, $date, $type = 'FT01', $status = 'FS01')
    {
        $doc = new DocNoMaker();
        $no = $doc->Generate('FZ');

        $model = $this->newitem();
        $model->frozen_no = $no;
        $model->frozen_cointtype = $coinType;
        $model->frozen_coinaccoint = $coinId;
        $model->frozen_userid = $userId;
        $model->frozen_type = $type;
        $model->frozen_jobno = $jobNo;
        $model->frozen_deadline = $date;
        $model->frozen_status = $status;
        $this->save($model);
        return $no;
    }

    /**
     * 查找解冻时间到的解冻
     *
     * @param   $status 状态
     * @param   $type 类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.6
     */
    public function getList($status, $type)
    {
        $model = $this->newitem();
        $time = date('Y-m-d H:i:s');
        $list = $model->where('frozen_deadline', '<=', $time)
            ->where('frozen_status', $status)
            ->where('frozen_type', $type)
            ->get();
        return $list;
    }

    /**
     * 查找解冻时间到的
     *
     * @param   $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.9.15
     */
    public function getFrozens($status)
    {
        $model = $this->newitem();
        $time = date('Y-m-d H:i:s');
        $list = $model->where('frozen_deadline', '<=', $time)
            ->where('frozen_status', $status)
            ->get();
        return $list;
    }


    /**
     * 修改状态
     *
     * @param   $no 解冻单据号
     * @param   $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.6
     */
    public function saveStatus($no, $status)
    {
        $info = $this->getByNo($no);
        $info->frozen_status = $status;
        $res = $this->save($info);
        return $res;
    }

    /**
     * 解冻操作
     *
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.6
     * 
     * 解除所有冻结的
     * @author  zhoutao
     * @date    2017.9.15
     */
    public function RelieveForzen()
    {
        $date = date('Y-m-d H:i:s');
        $orderData = new TranactionOrderData();
        $AccountData = new CoinAccountData();
        $journalData = new CoinJournalData();
        $status = FrozenData::FROZEN_STATUS;
        $forzen = $this->getFrozens($status);

        DB::beginTransaction();
        foreach ($forzen as $col => $val) {
            $orderInfo = $orderData->getByNo($val->frozen_jobno);
            if (!empty($orderInfo)) {
                $relieveCount = $orderInfo->order_coin;

                //更改用户代币余额 += 解冻数量 在途 -= 解冻数量
                $accountRes = $AccountData->saveCashPending($val->frozen_cointtype, $relieveCount, $relieveCount, $val->frozen_userid, $date);
                if ($accountRes === false) {
                    DB::rollBack();
                    return false;
                }

                //写入用户代币流水 收入 = +解冻数量 在途 = -解冻数量
                $userCoinJournalNo = '111';
                $journalRes = $journalData->addCoinJournal($accountRes, $val->frozen_cointtype, $userCoinJournalNo, -$relieveCount, $val->frozen_no, 'CJT02', 'UOJ10', $relieveCount, 0, $val->frozen_userid, $date);
                if ($journalRes === false) {
                    DB::rollBack();
                    return false;
                }

                //修改状态为解冻
                $forzenRes = $this->saveStatus($val->frozen_no, 'FS02');
                if ($forzenRes === false) {
                    DB::rollBack();
                    return false;
                }
            }
            
        }

        DB::commit();
        return true;
    }

    /**
     * 解冻详细
     *
     * @author zhoutao
     * @date   2017.11.13
     */
    public function unFrozen($frozenNo, $count, $date)
    {
        $frozen = $this->getByNo($frozenNo);
        if (!empty($frozen)) {
            $status = $frozen->frozen_status;
            $coinType = $frozen->frozen_cointtype;
            $userid = $frozen->frozen_userid;
            if ($status == self::FROZEN_STATUS) {
                $accountData = new CoinAccountData();
                //更改用户代币余额 += 解冻数量 在途 -= 解冻数量
                $accountRes = $accountData->increaseCashReducePending($coinType, $frozenNo, $count, $count, $userid, CoinJournalData::UNFROZEN_TYPE, CoinJournalData::SUCCESS_STATUS, $date);

                //修改状态为解冻
                $this->saveStatus($frozenNo, self::UNFROZEN_STATUS);
            }
        }
    }

    /**
     * 根据关联号查出冻结单
     *
     * @param  $jobNo 关联单号
     * @author zhoutao
     * @date   2017.11.13
     */
    public function getFrozenByJobNo($jobNo)
    {
        $model = $this->modelclass;
        $where['frozen_jobno'] = $jobNo;
        return $model::where($where)->first();
    }

    public function getFrozenList()
    {
        $model = $this->newitem();
    }

    private $_frozenJobMap = [
        'BLD' => 'App\Data\Lending\LendingDocInfoData',
        'TO' => 'App\Data\Trade\TranactionOrderData',
    ];

    /**
     * 用户代币列表查询冻结信息
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.13
     * 
     * 把平米变成份
     * @author  zhoutao
     * @date    2017.10.22
     * 
     * 修改成根据单据号来决定不同的data查询
     * @author  zhoutao
     * @date    2017.11.13
     */
    public function getCoinFrozens($userid, $coinType)
    {
        $orderData = new TranactionOrderData();
        $dicData = new DictionaryData();
        $adapterFac = new \App\Data\AdapterFac;
        $model = $this->newitem();
        $where['frozen_userid'] = $userid;
        $where['frozen_cointtype'] = $coinType;
        $frozens = $model->where($where)->get();
        $res = [];
        foreach ($frozens as $v) {
            foreach ($this->_frozenJobMap as $key => $val) {
                if (strpos(strval($v->frozen_jobno), strval($key)) === 0) {
                    $jobData = new $val;
                }
            }
            $jobInfo = $jobData->getByNo($v->frozen_jobno);
            if (!empty($jobInfo)) {
                $arr = $adapterFac->getDataContract($jobInfo);
                $count = $arr['count'];
                $scale = $arr['scale'];
                if (empty($count)) {
                    $count = 0;
                }
                $frozenInfo = [];
                $frozenInfo['deadline'] = date('y-m-d', strtotime($v->frozen_deadline));
                $frozenInfo['count'] = $scale == 0 ? 0 : $count / $scale;
                $type = $dicData->getDictionary('coin_frozen', $v->frozen_type);
                $frozenInfo['type']['no'] = $type->dic_no;
                $frozenInfo['type']['name'] = $type->dic_name;
                $res[] = $frozenInfo;
            }
            
        }
        return $res;
    }
}
