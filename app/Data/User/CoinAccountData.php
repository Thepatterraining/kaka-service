<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Support\Facades\DB;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinJournalData;
use \Exception;
use App\Data\Sys\LockData;
use App\Data\Project\ProjectInfoData;
use App\Data\Project\ProjectGuidingPriceData;
use App\Data\Trade\CoinSellData;

class CoinAccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\User\CoinAccount';

    const ERROR_MSG = '账户异常，请联系管理员';

    /**
     * 清算代币
     */
    function clearCoin($coinType, $price) {
         $lockData = new LockData;
        $key = "userCoinClear" . $coinType;
        $lockData->lock($key);

        DB::beginTransaction();

        //查询这个代币得所有账户
        $date = date("Y-m-d H:i:s");
        $model = $this->newitem();
        $coins = $model->where("usercoin_cointype", $coinType)->get();
        $userCashAccountData = new CashAccountData;
        $userCoinJournal = new CoinJournalData;

        //撤销所有这个代币得卖单
        $transactionSellData = new TranactionSellData();
        $coinSellData = new CoinSellData;
        $sellModel = $transactionSellData->newitem();
        $sells = $sellModel->where("sell_cointype", $coinType)->whereIn("sell_status", [TranactionSellData::NEW_SELL_STATUS, TranactionSellData::PARTIAL_TRANSACTION_STATUS])->get();
        foreach ($sells as $sell) {
            $coinSellData->revokeSell($sell->sell_no, $date);
        }

        foreach ($coins as $coin) {
            //持有代币数量
            $count = $coin->usercoin_cash;
            //应该给客户得现金
            $cash = bcmul(strval($count), strval($price), 2);
            $userCashAccountData->revokeOrder("",CashJournalData::CLEAR_TYPE,CashJournalData::CLEAR_STATUS,$cash,$coin->usercoin_account_userid);
            
            //清除用户所有代币
            $this->reduceCash($coinType,"",CashJournalData::CLEAR_STATUS,CashJournalData::CLEAR_TYPE,$count,$coin->usercoin_account_userid);
        }

        DB::commit();

        $lockData->unlock($key);

    }

    /**
     * 添加用户代币账户
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addUserCoin($coinType, $userid = null, $isprimay = true)
    {
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        $model = $this->newitem();
        $model->usercoin_account_userid = $userid;
        $model->usercoin_cointype = $coinType;
        if ($isprimay === true) {
            $model->usercoint_isprimary = 1;
        }
        return $model->save();
    }

    /**
     * 查询用户代币账户
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCoin($coinType, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $where['usercoin_account_userid'] = $userid;
        $where['usercoin_cointype'] = $coinType;
        return $this->find($where);
    }

    /**
     * 获取用户代币余额
     */
    public function getUserCoinCash($coinType, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $where['usercoin_account_userid'] = $userid;
        $where['usercoin_cointype'] = $coinType;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->usercoin_cash;
    }

    /**
     * 获取用户代币冻结
     */
    public function getUserCoinPending($coinType, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $where['usercoin_account_userid'] = $userid;
        $where['usercoin_cointype'] = $coinType;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->usercoin_pending;
    }

    /**
     * 获取用户账户id
     *
     * @param  $coinType 代币类型
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.9.8
     */
    public function getAccountid($coinType, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $where['usercoin_account_userid'] = $userid;
        $where['usercoin_cointype'] = $coinType;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->id;
    }

    /**
     * 查询是否1级市场用户的币类型
     *
     * @param $userid
     * @param $coinType
     */
    public function GetCoin($userid, $coinType)
    {
        $where['usercoin_account_userid'] = $userid;
        $where['usercoin_cointype'] = $coinType;
        $where['usercoint_isprimary'] = 1;
        return $this->findForUpdate($where);
    }

    /**
     * 查询用户所有代币账户
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCoinList()
    {
        $where['usercoin_account_userid'] = $this->session->userid;
        return $this->find($where);
    }

    /**
     * 查询用户所有代币账户
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getInfo($userid)
    {
        $model=$this->newitem();
        return $model->where('usercoin_account_userid', $userid)->get();
    }

    /**
     * 修改用户代币余额
     *
     * @param   $coinType 代币类型
     * @param   $count 代币数量
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserCoin($coinType, $count, $userid = null, $date = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $coinInfo = $this->getUserCoin($coinType, $userid);
        $pending = $coinInfo->usercoin_pending + $count;
        $cash = $coinInfo->usercoin_cash - $count;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_cash = $cash;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     * 修改用户代币在途 增加
     *
     * @param  $userid 用户id
     * @param  $coinType 代币类型
     * @param  $count 数量
     * @return mixed
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function savePending($userid, $coinType, $count, $isPrimary, $date = null)
    {
        if ($isPrimary === true) {
            $coinInfo = $this->GetCoin($userid, $coinType);
        } else {
            $coinInfo = $this->getUserCoin($coinType, $userid);
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $pending = $coinInfo->usercoin_pending + $count;
        $cash = $coinInfo->usercoin_cash;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     * 撤销卖单 修改用户代币余额
     *
     * @param   $coinType 代币类型
     * @param   $count 代币数量
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserCoinCash($coinType, $count, $userid = null, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $coinInfo = $this->getUserCoin($coinType, $userid);
        $pending = $coinInfo->usercoin_pending - $count;
        $cash = $coinInfo->usercoin_cash + $count;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_cash = $cash;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }


    /**
     * 余额增加 在途减少
     *
     * @param   $coinType 代币
     * @param   $cash 余额
     * @param   $pending 在途
     * @param   null            $userid 用户
     * @param   null            $date   日期
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveCashPending($coinType, $cash, $pending, $userid = null, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $coinInfo = $this->getUserCoin($coinType, $userid);
        $pending = $coinInfo->usercoin_pending - $pending;
        $cash = $coinInfo->usercoin_cash + $cash;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_cash = $cash;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     * 余额减少 在途增加
     *
     * @param   $coinType 代币
     * @param   $cash 余额
     * @param   $pending 在途
     * @param   null            $userid 用户
     * @param   null            $date   日期
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function savePendingCash($coinType, $cash, $pending, $userid = null, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $coinInfo = $this->getUserCoin($coinType, $userid);
        $pending = $coinInfo->usercoin_pending + $pending;
        $cash = $coinInfo->usercoin_cash - $cash;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_cash = $cash;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     * 减少在途
     *
     * @param   $coinType 代币类型
     * @param   $count 数量
     * @param   null                  $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function savePendingShao($coinType, $count, $userid = null, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $coinInfo = $this->getUserCoin($coinType, $userid);
        $pending = $coinInfo->usercoin_pending - $count;
        $cash = $coinInfo->usercoin_cash;
        $id = $coinInfo->id;
        $coinInfo->usercoin_pending = $pending;
        $coinInfo->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coinInfo->usercoin_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $coinInfo->save();
        $res['pending'] = $pending;
        $res['cash'] = $cash;
        $res['id'] = $id;
        return $res;
    }


    /**
     * 判断代币余额是否足够
     *
     * @param   $coinType 代币类型
     * @param   $amount 提现数量
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function isCash($coinType, $amount)
    {
        $coinInfo = $this->getUserCoin($coinType);
        if ($coinInfo == null) {
            return false;
        }
        if (bccomp(floatval($amount), floatval($coinInfo->usercoin_cash), 9) === 1) {
            return false;
        }
        return true;
    }

    /**
     * 判断是否为一级市场
     *
     * @param   $coinType 代币类型
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * 
     * 改成没有就认为是二级用户
     * @author  zhoutao
     * @date    2017.9.4
     */
    public function isPrimary($coinType)
    {
        $coinInfo = $this->getUserCoin($coinType);
        if ($coinInfo == null) {
            return true;
        }
        if ($coinInfo->usercoint_isprimary == 1) {
            return false;
        }
        return true;
    }

    /**
     * 将一级市场的代币改为普通
     *
     * @param   $coinType 代币类型
     * @param   $userid userid
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.26
     */
    public function savePrimary($coinType, $userid)
    {
        $model = $this->getUserCoin($coinType, $userid);
        $model->usercoint_isprimary = false;
        return $this->save($model);
    }

    /**
     * 更新锁定时间
     *
     * @param   $coinType 代币类型
     * @param   $userid userid
     * @param   $lockTime 锁定时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.9.6
     */
    public function saveLockTIme($coinType, $userid, $lockTime)
    {
        $model = $this->getUserCoin($coinType, $userid);
        $model->usercoin_locktime = $lockTime;
        return $this->save($model);
    }

    /**
     * 查询该用户持有资产的数量
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCount()
    {
        $where['usercoin_account_userid'] = $this->session->userid;
        $model = $this->newitem();
        $count = $model->where($where)->count();
        return $count;
    }

    /**
     * 查询持有资产数量和转让中资产数量
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCoinCounts()
    {
        $coinCount = $this->getUserCount();
        $sellData = new TranactionSellData();
        $sellCount = $sellData->getUserCount();
        $count['count'] = $coinCount;
        $count['sellCount'] = $sellCount;
        return $count;
    }

    /*
     * 查询该用户所有代币
     * @author zhoutao
     * @version 0.1
     */
    public function getUserCoins()
    {
        $where['usercoin_account_userid'] = $this->session->userid;
        $model = $this->newitem();
        $coins = $model->where($where)->get();
        return $coins;
    }

    /**
     * 查询房产估值
     *
     * @author  zhoutao
     * @version 0.1
     * 
     * 修改估值计算为 数量 * 项目指导价
     * @author  zhoutao
     * @date    2017.9.21
     * 
     * 修改估值使用比例因子
     * @author  zhoutao
     * @date    2017.10.11
     * 
     * 更改查询项目信息和项目指导价
     * @author  zhoutao
     * @date    2017.10.18
     * 
     * 修改项目指导价的获取
     * @author  zhoutao
     * @date    2017.10.20
     */
    public function getAssets()
    {
        $coins = $this->getUserCoins();
        $orderData = new TranactionOrderData();
        $userTypeData = new UserTypeData();
        $projectInfoData = new ProjectInfoData;
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $cashSum = $this->getSum('usercoin_cash');
        $pendingSum = $this->getSum('usercoin_pending');
        $countSum = $cashSum + $pendingSum;
        $res = [];
        if (count($coins) > 0) {
            foreach ($coins as $coin) {
                //查找该代币最新成交价
                $coinType = $coin->usercoin_cointype;
                $orderInfo = $orderData->getInfo($coinType);
                $orderPrice = $orderInfo['price'];
                $sysConfigs = $userTypeData->getData($this->session->userid);

                //查询项目信息
                $projectInfo = $projectInfoData->getByNo($coinType);
                $currentPrice = 0;
                $projectGuidingPrice = $projectGuidingPriceData->getGuidingPrice($coinType);
                if (!empty($projectGuidingPrice)) {
                    $currentPrice = $projectGuidingPrice->project_guidingprice;
                }
                $arr['scale'] = empty($projectInfo) ? 0 : $projectInfo->project_scale;

                //进行估值
                $count = $coin->usercoin_cash + $coin->usercoin_pending;
                $valuation = $count / $arr['scale']  * $currentPrice;
                $arr['valuation'] = $arr['scale'] == 0 ? 0 : $valuation;

                //进行占比率
                if ($countSum != 0) {
                    $arr['percentage'] = $count / $countSum;
                } else {
                    $arr['percentage'] = 0;
                }
                

                
                $arr['name'] = empty($projectInfo) ? '' : $projectInfo->project_name;
                $arr['count'] = $count;
                $res[] = $arr;
            }
        }
        return $res;
    }

    /**
     * 查询该用户的和
     *
     * @param   $sumFiled 求和的字段
     * @author  zhoutao
     * @version 0.1
     */
    public function getSum($sumFiled)
    {
        $where['usercoin_account_userid'] = $this->session->userid;
        $model = $this->newitem();
        $sum = $model->where($where)->sum($sumFiled);
        return $sum;
    }

    /**
     * 查询该用户代币总价值
     *
     * @author  liu
     * @version 0.1
     */
    public function getUserCoinsPrice($id='')
    {
        $tranactionOrderData=new TranactionOrderData();
        if(empty($id)) {
            $id=$this->session->userid;
        }
        $where['usercoin_account_userid'] = $id;
        $model = $this->newitem();
        $coins = $model->where($where)->get();
        if(empty($coins)) {
            return 0;
        }
        else
        {
            $coinsPrice=0;
            //计算代币价值
            foreach($coins as $coin)
            {
                $coinInfo=$tranactionOrderData->getInfo($coin->usercoin_cointype);
                $price=$coinInfo['price'];
                $coinCash=$coin->usercoin_cash;
                $coinPending=$coin->usercoin_pending;
                $coinsPrice=$coinsPrice+($coinCash+$coinPending)*$price;
            }
            //var_dump($coinsPrice);
            return $coinsPrice;
        }
    }

    /**
     * 增加用户代币余额
     *
     * @param  $coinType 代币类型
     * @param  $orderNo 关联单号
     * @param  $status 状态
     * @param  $type 类型
     * @param  $in 收入
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function revokeOrder($coinType,$orderNo,$status,$type,$in,$userid)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        $date = date('Y-m-d H:i:s');
        $coin = $this->getUserCoin($coinType, $userid);
        $coin->usercoin_cash += $in;
        $coin->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coin->usercoin_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($coin);

        $userCoin['pending'] = $coin->usercoin_pending;
        $userCoin['cash'] = $coin->usercoin_cash;
        $userCoin['id'] = $coin->id;

        //写入代币流水
        $userCoinJournal = new CoinJournalData;
        $userCoinJournal->addCoinJournal($userCoin, $coinType, '', 0, $orderNo, $status, $type, $in, 0, $userid, $date);
        
        $lockData->unlock($key);
    }


    /**
     * 减少用户代币余额
     *
     * @param  $coinType 代币类型
     * @param  $orderNo 关联单号
     * @param  $status 状态
     * @param  $type 类型
     * @param  $in 收入
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function reduceCash($coinType,$orderNo,$status,$type,$out,$userid)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        $date = date('Y-m-d H:i:s');
        $coin = $this->getUserCoin($coinType, $userid);
        $coin->usercoin_cash -= $out;
        $coin->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($coin->usercoin_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($coin);

        $userCoin['pending'] = $coin->usercoin_pending;
        $userCoin['cash'] = $coin->usercoin_cash;
        $userCoin['id'] = $coin->id;

        //写入代币流水
        $userCoinJournal = new CoinJournalData;
        $userCoinJournal->addCoinJournal($userCoin, $coinType, '', 0, $orderNo, $status, $type, 0, $out, $userid, $date);
    
        $lockData->unlock($key);
    }

    /**
     * 查询项目数量
     *
     * @author zhoutao
     */
    public function getUserCoinCount()
    {
        $model = $this->modelclass;
        $where['usercoin_account_userid'] = $this->session->userid;
        return $model::where('usercoin_account_userid', $this->session->userid)->where(
            function ($query) {
                $query->orWhere('usercoin_cash', '>', '0')
                    ->orWhere('usercoin_pending', '>', '0');
            }
        )->count();
    }

    /**
     * 查询持有用户总数
     *
     * @author zhoutao
     */
    public function getCoinCountUsers($coinType)
    {
        $model = $this->modelclass;
        return $model::where('usercoin_cointype', $coinType)->where(
            function ($query) {
                $query->orWhere('usercoin_cash', '>', '0')
                    ->orWhere('usercoin_pending', '>', '0');
            }
        )->count();
    }

    /**
     * 增加金额 减少在途
     *
     * @param  $coinType 代币类型
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $pending 在途的金额
     * @param  $userid 用户id
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.8.22
     * 
     * 修改了返回值
     * @author zhoutao
     * @date   2017.8.25
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function increaseCashReducePending($coinType, $jobNo, $cash, $pending, $userid, $type, $status, $date = null)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $info = $this->getUserCoin($coinType, $userid);
        $info->usercoin_cash += $cash;
        $info->usercoin_pending = bcsub(strval($info->usercoin_pending), strval($pending), 9);
        $info->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($info->usercoin_pending < 0) {
            info('金额'.$amount);
            info($model->account_pending);
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCoin['pending'] = $info->usercoin_pending;
        $userCoin['cash'] = $info->usercoin_cash;
        $userCoin['id'] = $info->id;

        //写入用户流水
        $userCashJournalData = new CoinJournalData;
        $userCashJournalData->addCoinJournal($userCoin, $coinType, '', -$pending, $jobNo, $status, $type, $cash, 0, $userid, $date);

        $lockData->unlock($key);
        return $userCoin;
    }

    /**
     * 减少金额 增加在途
     *
     * @param  $coinType 代币类型
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $pending 在途的金额
     * @param  $userid 用户id
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.8.22
     * 
     * 修改了返回值
     * @author zhoutao
     * @date   2017.8.25
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function reduceCashIncreasePending($coinType, $jobNo, $cash, $pending, $userid, $type, $status, $date = null)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $info = $this->getUserCoin($coinType, $userid);
        $info->usercoin_cash = bcsub(strval($info->usercoin_cash), strval($cash), 9);
        $info->usercoin_pending += $pending;
        $info->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($info->usercoin_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCoin['pending'] = $info->usercoin_pending;
        $userCoin['cash'] = $info->usercoin_cash;
        $userCoin['id'] = $info->id;

        //写入用户流水
        $userCashJournalData = new CoinJournalData;
        $userCashJournalData->addCoinJournal($userCoin, $coinType, '', $pending, $jobNo, $status, $type, 0, $cash, $userid, $date);

        $lockData->unlock($key);
        return $userCoin;
    }

    /**
     * 增加在途
     *
     * @param  $coinType 代币类型
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $pending 在途的金额
     * @param  $userid 用户id
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.11.9
     */
    public function increasePending($coinType, $jobNo, $pending, $userid, $type, $status, $date = null)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $info = $this->getUserCoin($coinType, $userid);
        $info->usercoin_pending += $pending;
        $info->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($info->usercoin_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCoin['pending'] = $info->usercoin_pending;
        $userCoin['cash'] = $info->usercoin_cash;
        $userCoin['id'] = $info->id;

        //写入用户流水
        $userCashJournalData = new CoinJournalData;
        $userCashJournalData->addCoinJournal($userCoin, $coinType, '', $pending, $jobNo, $status, $type, 0, 0, $userid, $date);

        $lockData->unlock($key);
        return $userCoin;
    }

    /**
     * 减少在途
     *
     * @param  $coinType 代币类型
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $pending 在途的金额
     * @param  $userid 用户id
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.11.9
     */
    public function reducePending($coinType, $jobNo, $pending, $userid, $type, $status, $date = null)
    {
        $lockData = new LockData;
        $key = "userCoin" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $info = $this->getUserCoin($coinType, $userid);
        $info->usercoin_pending -= bcsub(strval($info->usercoin_pending), strval($pending), 9);
        $info->usercoin_change_time = $date;

        //判断在途为负则返回错误
        if ($info->usercoin_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCoin['pending'] = $info->usercoin_pending;
        $userCoin['cash'] = $info->usercoin_cash;
        $userCoin['id'] = $info->id;

        //写入用户流水
        $userCashJournalData = new CoinJournalData;
        $userCashJournalData->addCoinJournal($userCoin, $coinType, '', -$pending, $jobNo, $status, $type, 0, 0, $userid, $date);

        $lockData->unlock($key);
        return $userCoin;
    }

}
