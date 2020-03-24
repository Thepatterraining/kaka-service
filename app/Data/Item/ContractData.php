<?php
namespace App\Data\Item;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Product\InfoData as ProductData;
use App\Data\User\UserTypeData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Utils\DocNoMaker;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\User\CashOrderData;
use App\Data\Project\ProjectInfoData;
use App\Data\Project\ProjectCompanyData;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;

class ContractData extends IDatafactory
{

    protected $modelclass = 'App\Model\Trade\TranactionContract';

    protected $no = 'contract_no';

    const LEVEL_TYPE_ONE = 'S';
    const LEVEL_TYPE_TWO = 'T';

    const LEVEL_TYPE_PRODUCT = 'CL01';
    const LEVEL_TYPE_MARKET = 'CL00';

    /**
     * 查询收益权
     *
     * @param  $productNo 产品号
     * @param  $count 份数
     * @author zhoutao
     * 
     * 1 查询产品信息
     * 2 查询项目表，查询出丁方信息
     * 3 查询系统配置 查询出丙方信息
     * 4 查询买方信息
     * 5 查询卖方信息
     * 6 计算总额 费率等
     * 
     * 把产品单号改成卖单号
     * @param  $sellNo 卖单号
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getUsufruct($sellNo, $count)
    {
        $sellData = new TranactionSellData;
        $projectInfoData = new ProjectInfoData;
        $userTypeData = new UserTypeData;
        $userData = new UserData;
        $userAdapter = new UserAdapter;
        $projectCompanyData = new ProjectCompanyData;


        $userid = $this->session->userid;
        $sell = $sellData->getByNo($sellNo);

        $res = [];
        if (!empty($sell)) {
            $coinType = $sell->sell_cointype;
            $sellUserid = $sell->sell_userid;
            $price = $sell->sell_touser_showprice;

            //查询项目信息 （丁方）
            $projectInfo = $projectInfoData->getByNo($coinType);
            $space = $projectInfo->project_coinammount;
            $holdType = $projectInfo->project_holdtype;
            $holderid = $projectInfo->project_holderid;
            $companAgent = '';
            $companNo = '';
            $companyName = '';
            $companySign = '';
            $modelData=new ModelData();
            $modelId=$modelData->getModelIdByModel($projectInfo);
            if ($holdType == ProjectInfoData::HOLD_TYPE_COMPANY) {
                $company = $projectCompanyData->get($holderid);
                if (!empty($company)) {
                    $companyName = $company->company_name;
                    $companNo = $company->company_no;
                    $companAgent = $company->company_representative;

                    $resourceIndexData = new ResourceIndexData;
                    $imgUrl = $resourceIndexData->getUrl($modelId, $projectInfo->id, ResourceIndexData::COMPANY_SIGN);
                    $companySign = $imgUrl;
                    
                }
                
            }
            $partner['companyName'] = $companyName;
            $partner['companySign'] = $companySign;
            $partner['fourthAgent'] = $companAgent; //法人
            $partner['fourthNo'] = $companNo; //注册号

            //查询配置信息 （丙方）
            $sysConfigs = $userTypeData->getData($userid);
            $platform['companyName'] = $sysConfigs[UserTypeData::COMPANY_NAME];
            $platform['companySign'] = $sysConfigs[UserTypeData::COMPANY_SIGN];
            $platform['companyAgent'] = $sysConfigs[UserTypeData::COMPANY_AGENT];
            $platform['companyNo'] = $sysConfigs[UserTypeData::COMPANY_NO];

            //查询用户信息 （甲乙）
            $buyUser = $userData->get($userid);
            $userArray = ['name','idno','mobile'];
            if (!empty($buyUser)) {
                $buyUser = $userAdapter->getDataContract($buyUser, $userArray);
            }

            $sellUser = $userData->get($sellUserid);

            if (!empty($sellUser)) {
                $sellUser = $userAdapter->getDataContract($sellUser, $userArray);
            }

            //计算总额 费率 收益
            $amount = $price * $count;
            $usufruct = $count / ($space * 100);

            
            $sellCashFeeType = $sysConfigs[UserTypeData::$CASH_SELL_FEE_TYPE];
            switch ($sellCashFeeType) {
            case ProductData::$SELL_FEE_TYPE_FREE :
                $sellCashFeeRate = 0;
                break;
            case ProductData::$SELL_FEE_TYPE_IN :
                $sellCashFeeRate = $sysConfigs[UserTypeData::$CASH_SELL_FEE_RATE];
                break;
            case ProductData::$SELL_FEE_TYPE_OUT :
                $sellCashFeeRate = $sysConfigs[UserTypeData::$CASH_SELL_FEE_RATE];
                break;
            default :
                $sellCashFeeRate = $sysConfigs[UserTypeData::$CASH_SELL_FEE_RATE];
                break;
            }

            $res['contractNo'] = '';
            $res['amount'] = $amount;
            $res['sellCashFeeRate'] = $sellCashFeeRate;
            $res['sellCashFeeType'] = $sellCashFeeType;
            $res['usufruct'] = $usufruct; 
            $res['buyUser'] = $buyUser; //乙方
            $res['sellUser'] = $sellUser; //甲方
            $res['platform'] = $platform; //丙方
            $res['partner'] = $partner;  //丁方

        }

        return $res;
        

    }

    /**
     * 添加收益权合同
     *
     * @param  $orderNo 成交单号
     * @author zhoutao
     * 
     * 1 查询成交单信息
     * 2 查询产品信息
     * 3 查询收益权信息
     * 4 得到合同单号
     * 5 写入
     * 
     * 增加一级二级市场的级别
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 增加为空设为空字符串
     * @author zhoutao
     * @date   2017.10.24
     */
    public function add($orderNo, $levelType)
    {
        $orderData = new TranactionOrderData;
        $order = $orderData->getByNo($orderNo);
        $count = $order->order_count / $order->order_scale;
        $sellNo = $order->order_sell_no;
        $coinType = $order->order_coin_type;

        $usufructs = $this->getUsufruct($sellNo, $count);
        if (!empty($usufructs)) {
            $no = DocNoMaker::getContractNo($coinType, self::LEVEL_TYPE_ONE);
            $contractAmount = array_get($usufructs, 'amount');
            $contractCount = array_get($usufructs, 'usufruct');
            $contractRate = array_get($usufructs, 'sellCashFeeRate');
            $firstNo = array_get($usufructs, 'sellUser.idno');
            $firstName = array_get($usufructs, 'sellUser.name');
            $firstAgent = array_get($usufructs, 'sellUser.name');
            $secondNo = array_get($usufructs, 'buyUser.idno');
            $secondName = array_get($usufructs, 'buyUser.name');
            $secondAgent = array_get($usufructs, 'buyUser.name');
            $thirdNo = array_get($usufructs, 'platform.companyNo');
            $thirdName = array_get($usufructs, 'platform.companyName');
            $thirdAgent = array_get($usufructs, 'platform.companyAgent');
            $thirdSign = array_get($usufructs, 'platform.companySign');
            $fourthNo = array_get($usufructs, 'partner.fourthNo');
            $fourthName = array_get($usufructs, 'partner.companyName');
            $fourthAgent = array_get($usufructs, 'partner.fourthAgent');
            $fourthSign = array_get($usufructs, 'partner.companySign');

            $model = $this->newitem();
            $model->contract_no = $no;
            $model->transaction_orderno = $orderNo;
            $model->contract_amount = empty($contractAmount) ? 0 : $contractAmount;
            $model->contract_count = empty($contractCount) ? 0 : $contractCount;
            $model->contract_rate = empty($contractRate) ? 0 : $contractRate;
            $model->contract_date = date('Y-m-d H:i:s');
            $model->first_no = empty($firstNo) ? '' : $firstNo;
            $model->first_name = empty($firstName) ? '' : $firstName;
            $model->first_agent = empty($firstAgent) ? '' : $firstAgent;
            $model->frist_sign = '';
            $model->second_no = empty($secondNo) ? '' : $secondNo;
            $model->second_name = empty($secondName) ? '' : $secondName;
            $model->second_agent = empty($secondAgent) ? '' : $secondAgent;
            $model->second_sign = '';
            $model->third_no = empty($thirdNo) ? '' : $thirdNo;
            $model->third_name = empty($thirdName) ? '' : $thirdName;
            $model->third_agent = empty($thirdAgent) ? '' : $thirdAgent;
            $model->third_sign = empty($thirdSign) ? '' : $thirdSign;
            $model->fourth_no = empty($fourthNo) ? '' : $fourthNo;
            $model->fourth_name = empty($fourthName) ? '' : $fourthName;
            $model->fourth_agent = empty($fourthAgent) ? '' : $fourthAgent;
            $model->fourth_sign = empty($fourthSign) ? '' : $fourthSign;
            $model->contract_leveltype = $levelType;
            $this->create($model);
        }

    }

    /**
     * 查询收益权
     *
     * @param  $cashOrderNo 现金账单号
     * @author zhoutao
     * 
     * 1 查询出现金账单
     * 2 获取成交单号 查合同信息
     */
    public function getCashBillUsufruct($cashOrderNo)
    {
        $cashOrderData = new CashOrderData;
        $orderData = new TranactionOrderData;
        $cashOrder = $cashOrderData->getByNo($cashOrderNo);

        $res = [];
        if (!empty($cashOrder)) {
            $orderNo = $cashOrder->usercashorder_jobno;
            $contract = $this->getContract($orderNo);

            if (!empty($contract)) {
                $res = array_add($res, 'contractNo', $contract->contract_no);
                $res = array_add($res, 'amount', $contract->contract_amount);
                $res = array_add($res, 'usufruct', $contract->contract_count);
                $res = array_add($res, 'sellCashFeeRate', $contract->contract_rate);
                $res = array_add($res, 'sellUser.idno', $contract->first_no);
                $res = array_add($res, 'sellUser.name', $contract->first_name);
                $res = array_add($res, 'buyUser.idno', $contract->second_no);
                $res = array_add($res, 'buyUser.name', $contract->second_name);
                $res = array_add($res, 'platform.companyNo', $contract->third_no);
                $res = array_add($res, 'platform.companyName', $contract->third_name);
                $res = array_add($res, 'platform.companyAgent', $contract->third_agent);
                $res = array_add($res, 'platform.companySign', $contract->third_sign);
                $res = array_add($res, 'partner.fourthNo', $contract->fourth_no);
                $res = array_add($res, 'partner.companyName', $contract->fourth_name);
                $res = array_add($res, 'partner.fourthAgent', $contract->fourth_agent);
                $res = array_add($res, 'partner.companySign', $contract->fourth_sign);
            }
        }

        return $res;

    }

    /**
     * 查询合同信息
     *
     * @param  $orderNo 成交单号
     * @author zhoutao
     */
    public function getContract($orderNo)
    {
        $where['transaction_orderno'] = $orderNo;
        
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if (empty($info)) {
            return '';
        }
        return $info;
    }

}
