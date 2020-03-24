<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class CoinJournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\User\CoinJournal';

    const ORDER_TYPE = 'UOJ07';
    const FROZEN_TYPE = 'UOJ09';
    const UNFROZEN_TYPE = 'UOJ10';
    const VOUCHER_TYPE = 'UOJ11';
    const SYS_TO_USER_TYPE = 'UOJ12'; //平台借给用户
    const USER_RETURN_TYPE = 'UOJ13'; //用户归还给平台

    const APPLY_STATUS = 'CJT01';
    const SUCCESS_STATUS = 'CJT02';
    const REVOKE_STATUS = 'CJT04';
    const FROZEN_STATUS = 'CJT07';
    const VOUCHER_STATUS = 'CJT08';

    /**
     * 添加用户代币流水表
     *
     * @param   $userCoin 用户代币账户信息
     * @param   $coinType 代币类型
     * @param   $userCoinJournalNo 用户代币流水单据号
     * @param   $count 代币数量
     * @param   $transactionSellNo 卖单单据号
     * @author  zhoutao
     * @version 0.1
     */
    public function addCoinJournal($userCoin, $coinType, $userCoinJournalNo, $count, $transactionSellNo, $status = 'CJT01', $type = 'UOJ07', $in = 0, $out = 0, $userId = null, $date)
    {
        $doc = new DocNoMaker();
        $userCoinJournalNo = $doc->Generate('UOJ');

        $docMd5 = new DocMD5Maker();
        if ($userId == null) {
            $userId = $this->session->userid;
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->newitem();
        $model->usercoin_journal_userid = $userId;
        $model->usercoin_result_pending = $userCoin['pending'];
        $model->usercoin_result_cash = $userCoin['cash'];
        $model->usercoin_journal_no = $userCoinJournalNo;
        $model->usercoin_journal_datetime = $date;
        $model->usercoin_journal_pending = $count;
        $model->usercoin_journal_in = $in;
        $model->usercoin_journal_out = $out;
        $model->usercoin_journal_type = $type; //类型 待定
        $model->usercoin_journal_cointype = $coinType; //代币类型
        $model->usercoin_journal_jobno = $transactionSellNo;
        $model->usercoin_journal_status = $status;
        $model->usercoin_journal_account = $userCoin['id']; //账户id
        return $docMd5->AddHash($model);
    }
    /**
     * 获取一定时间内用户买入币数
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @author  liu
     * @version 0.1
     */
    public function getBuyCoinToday($userId,$coinType,$start,$end)
    {
        $model=$this->newitem();
        $result=$model->where('usercoin_journal_cointype', $coinType)
            ->where('usercoin_journal_userid', $userId)
            ->where('usercoin_journal_status', 'CJT06')
            ->where('usercoin_journal_type', 'UOJ08')
            ->whereBetween('usercoin_journal_datetime', [$start,$end])
        //->where('usercoin_journal_pending','<','0')
            ->sum('usercoin_journal_in');
        return $result;
    }
    /**
     * 获取一定时间内用户卖出币数
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @author  liu
     * @version 0.1
     */
    public function getSellCoinToday($userId,$coinType,$start,$end)
    {
        $model=$this->newitem();
        $result=$model->where('usercoin_journal_cointype', $coinType)
            ->where('usercoin_journal_userid', $userId)
            ->where('usercoin_journal_status', 'CJT06')
            ->where('usercoin_journal_type', 'UOJ08')
            ->whereBetween('usercoin_journal_datetime', [$start,$end])
            ->sum('usercoin_journal_out');
        return $result;
    }

    /**
     * 获取一定时间内用户被冻结币数
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @author  liu
     * @version 0.1
     */
    public function getFrozenCoinToday($userId,$coinType,$start,$end)
    {
        $model=$this->newitem();
        $result=$model->where('usercoin_journal_cointype', $coinType)
            ->where('usercoin_journal_userid', $userId)
            ->where('usercoin_journal_status', 'CJT07')
            ->where('usercoin_journal_type', 'UOJ09')
            ->whereBetween('usercoin_journal_datetime', [$start,$end])
        //->where('usercoin_journal_pending','<','0')
            ->sum('usercoin_journal_pending');
        return $result;
    }

    /**
     * 获取截止到一定时间用户可用币数
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @author  liu
     * @version 0.1
     */
    public function getCashToday($userId,$coinType,$end)
    {
        $model=$this->newitem();
        // dump($end);
        $result=$model->orderBy('id', 'desc')
            ->where('usercoin_journal_cointype', $coinType)
            ->where('usercoin_journal_userid', $userId)
            ->where('usercoin_journal_datetime', '<', $end)
            ->first();
        //dump($result);
        if(!empty($result)) {
            $res=$result->usercoin_result_cash;
        }
        else 
        {
            $res=0; 
        }          
        return $res;
    }

    /**
     * 获取截止到一定时间用户在途币数
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @author  liu
     * @version 0.1
     */
    public function getPendingToday($userId,$coinType,$end)
    {
        $model=$this->newitem();
        $result=$model->orderBy('id', 'desc')
            ->where('usercoin_journal_cointype', $coinType)
            ->where('usercoin_journal_userid', $userId)
            ->where('usercoin_journal_datetime', '<', $end)
            ->first();
        if(!empty($result)) {
            $res=$result->usercoin_result_pending;
        }
        else 
        {
            $res=0; 
        }          
        return $res;
    }
}
