<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData;
use App\Data\Notify\INotifyDefault;
use App\Data\Api\SMS\SmsVerify;
use App\Data\Project\ProjectInfoData;

class ProjBonusItemData extends IDatafactory //implements INotifyDefault
{

    protected $modelclass = 'App\Model\Bonus\ProjBonusItem';

    protected $no = 'id';

    const EVENT_TYPE = 'Bonus_Check';

    /**
     * 写入分红子表
     *
     * @param  $bonusNo 分红单号
     * @param  $coinType 代币类型
     * @param  $authDate 确权时间
     * @param  $userid 用户id
     * @param  $count 代币数量
     * @param  $cash 分红金额
     * @author zhoutao
     * 
     * 增加项目名称
     * @author zhoutao
     * @date 2017.11.17
     * 增加分红周期
     * @param $bonusCycle 分红周期
     * @author zhoutao
     * @date 2017.11.22
     */
    public function add($bonusNo, $coinType, $authDate, $userid, $count, $cash, $bonusCycle)
    {
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);

        $model = $this->newitem();
        $model->bonus_no = $bonusNo;
        $model->bonus_proj = $coinType;
        $model->bonus_authdate = $authDate;
        $model->bonus_userid = $userid;
        $model->bonus_count = $count;
        $model->bonus_cash = $cash;
        $model->project_name = $projectInfo->project_name;
        $model->bonus_cycle = $bonusCycle;
        $this->create($model);
    }

    /**
     * 成功入账
     *
     * @param  $bonusNo 分红单号
     * @param  $userid 用户id
     * @param  $coinType 代币类型
     * @param  $authDate 确权时间
     * @author zhoutao
     * 
     * 增加返回id
     * @author zhoutao
     * @date   2017.10.2
     */
    public function saveSuccess($bonusNo,$userid,$coinType,$authDate)
    {
        $where['bonus_no'] = $bonusNo;
        $where['bonus_proj'] = $coinType;
        $where['bonus_userid'] = $userid;
        $where['bonus_authdate'] = $authDate;
        
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if (!empty($info)) {
            $info->bonus_success = 1;
            $this->save($info);
            return $info->id;
        }
        return 0;
    }

    /**
     * 查询该用户分红信息
     *
     * @param  $bonusNo 分红单号
     * @author zhoutao
     */
    public function getBonusItem($bonusNo)
    {
        $where['bonus_no'] = $bonusNo;
        $where['bonus_success'] = 1;
        $where['bonus_userid'] = $this->session->userid;
        $model = $this->modelclass;
        return $model::where($where)->first();
    }

    /**
     * 查询分红详情
     *
     * @param  $bonusNo bonus.no
     * @param  $userid 用户id
     * @param  $coinType 代币类型
     * @param  $authDate 确权时间
     * 
     * 增加返回值
     * @author zhoutao
     * @date   2017.10.16
     */
    public function getBonusItemDetails($bonusNo,$userid,$coinType,$authDate)
    {
        $where['bonus_no'] = $bonusNo;
        $where['bonus_proj'] = $coinType;
        $where['bonus_userid'] = $userid;
        $where['bonus_authdate'] = $authDate;
        
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        return $info;
    }

    // public function notifycreateddefaultrun($data)
    // {

    // }

    // /**
    //  * 根据分红单据下的分红子表发送信息
    //  * @param $data 数据
    //  */
    // public function notifysaveddefaultrun($data)
    // {
    //     $bonusNo = $data['bonus_no'];
    //     $coinType = $data['bonus_proj'];
    //     $authDate = $data['bonus_authdate'];
    //     $userId = $data['bonus_userid'];

    //     $where['bonus_no'] = $bonusNo;
    //     $where['bonus_proj'] = $coinType;
    //     $where['bonus_success'] = 1;
    //     $where['bonus_authdate'] = $authDate;
    //     $where['bouns_userid'] = $userId;

    //     $model = $this->modelclass;
    //     $bonusItem = $model::where($where)->first();
    //     $userData=new UserData();

    //     $userInfo=$userData->get($userId);
    //     if(!$userInfo->user_name)   
    //     {
    //         $name="用户";
    //     }
    //     else
    //     {
    //         $name=$userInfo->user_name;
    //     }
    //     $phone=$userInfo->user_mobile;
    //     $money=$data['bonus_count'];
    //     $user=$cashAccountData->getitem()->where('account_userid',$userId)->account_cash;
    //     // foreach ($bonusItems as $bonusItem) {
    //         // $userid = $bonusItem->bonus_userid;
    //     //通知用户
    //     $smsVerifyFac=new SmsVerifyFactory();
    //     $verify = $smsVerifyFac->CreateVerify();
    //     $verify->SendBonusNotify($phone, $bonusNo, $name, $money, $user);
    // }
    // public function notifydeleteddefaultrun($data)
    // {

    // }

    /**
     * 查询累计分红
     *
     * @param  $coinType
     * @author zhoutao
     * @date   2017.11.14
     */
    public function getSumIncome($coinType)
    {
        $model = $this->modelclass;
        $where['bonus_success'] = 1;
        $where['bonus_userid'] = $this->session->userid;
        $where['bonus_proj'] = $coinType;
        return $model::where($where)->sum('bonus_cash');
    }

    /**
     * 查询准备分红的子表
     *
     * @author zhoutao
     * @date   2017.11.16
     */
    public function getPreBonusItems($bonusNo, $coinType, $authDate)
    {
        $model = $this->modelclass;
        $where['bonus_success'] = 0;
        $where['bonus_proj'] = $coinType;
        $where['bonus_no'] = $bonusNo;
        $where['bonus_authdate'] = $authDate;
        return $model::where($where)->get();
    }

}
