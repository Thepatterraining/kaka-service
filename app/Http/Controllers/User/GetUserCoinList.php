<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\FrozenData;
use App\Data\Item\FormulaData;
use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\Coin\FrozenAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserTypeData;
use App\Data\Project\ProjectInvestsTypeDefineData;
use App\Http\Adapter\Project\ProjectInvestsTypeDefineAdapter;
use App\Data\Project\ProjectInfoData;
use App\Http\Adapter\Project\ProjectInfoAdapter;
use App\Data\Project\ProjectData;
use App\Data\Trade\TranactionSellData;
use App\Data\Project\ProjectGuidingPriceData;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;
use App\Data\Project\ProjectTypeData;
use App\Http\Adapter\Project\ProjectTypeAdapter;
use App\Data\Bonus\ProjBonusItemData;

class GetUserCoinList extends QueryController
{

    /**
     * @api {post} user/getusercoinlist 获取代币列表
     * @apiName getusercoins
     * @apiGroup Coin
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : token
     *      pageIndex : 页码
     *      pageSize : 每页数量
     *
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *              "id" => 9
     *               "userid" => 262  用户id
     *               "type" => "KKC-BJ0001" 代币类型
     *               "address" => "" 地址
     *               "cash" => "0.00000000" 拥有的平米
     *               "pending" => "34.17000000" 冻结的平米
     *               "price" => "0.000" 平均持币成本
     *               "value" => "0.000" 持币总成本
     *               "netprice" => "0.0000"   平均持币净成本 扣费的成本
     *               "netvalue" => "0.000"   持币净成本 扣费后成本
     *               "change_time" => "2017-06-01 19:43:03"   最后更新时间
     *               "settelment_time" => "1970-01-01 00:00:00"  最后对帐时间
     *               "primarycash" => "0.00000000"  一级市场首发余额
     *               "isprimary" => 1    是否为一级市场
     *               "item" => array:12 [
     *               "itemName" => "德胜房产系列001号"  项目名称
     *               "itemRegion" => "西城"  项目地区
     *               "itemKkName" => "咔咔北京数字一号房产" 项目代币名称
     *               "itemCompound" => "双旗杆东里"  小区名称
     *               "itemLayout" => "2室1厅1厨1卫"  户型
     *               "itemPrice" => 1455  市场指导价
     *               "itemSpace" => "50.55"  面积
     *               "changeDate" => "2024-09-01 00:00:00"  交割日期
     *               "itemSchool" => "西城"   教育属性
     *               "itemTerm" => 7   投资期限
     *               "rose" => "339.00000"  项目涨幅
     *               "cover_img1" => "/upload/KKC-BJ0001/img1.jpg"  项目图片
     *               ]
     *               "frozen" => array:6 [ 冻结信息
     *               0 => array:3 [
     *                   "deadline" => "17-08-20"   解冻日期
     *                   "count" => "0.01000000"   冻结数量
     *                   "type" => array:2 [ 类型
     *                   "no" => "FT01"
     *                   "name" => "用券交易"
     *                   ]
     *               ],...
     *               ]
     *               "order" => array:3 [
     *               "price" => 300 //最新成交价
     *               "date" => "2017/06/01 19:01:50"
     *               "rose" => -0.79674796747967
     *               ]
     *               "scale" => "0.01" 比例因子
     *              "valuation"=> 估值,
     *              "annualRate" => '50%' 年化收益
     *              "proceeds" => [ //收益类型
     *                  '浮动收益',
     *                  '固定分红',
     *              ],
     *              'investsType' => [ //投资类型
     *                  'id' => 1,
     *                  'name' => '激进型',
     *                  'note' => '我是激进型'
     *              ],
     *          }
     *  }
     */
    public function getData()
    {
        //解冻
        $forzenData = new FrozenData();
        $forzenAdapter = new FrozenAdapter();
        $forzenData->RelieveForzen();

        return new CoinAccountData;
    }

    public function getAdapter()
    {
        return new CoinAccountAdapter;
    }

    protected function getMergeFilters($arr)
    {
        $arr['usercoin_account_userid'] = $this->session->userid;
        return $arr;
    }

    protected function getItem($arr)
    {
        $data = new CoinAccountData();
        $adapter = new CoinAccountAdapter();
        $itemData = new InfoData();
        $formulaData = new FormulaData();
        $orderData = new TranactionOrderData();
        $orderAdapter = new TranactionOrderAdapter();
        $userTypeData = new UserTypeData();
        $projectInfoData = new ProjectInfoData;
        $projectInfoAdapter = new ProjectInfoAdapter;
        $investsTypeDefineData = new ProjectInvestsTypeDefineData;
        $investsTypeDefineAdapter = new ProjectInvestsTypeDefineAdapter;
        $projectData = new ProjectData;
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $forzenData = new FrozenData();
        $forzenAdapter = new FrozenAdapter();
        $projectTypeData = new ProjectTypeData;
        $projectTypeAdapter = new ProjectTypeAdapter;
        $bonusItemData = new ProjBonusItemData;
        $sellData = new TranactionSellData;


        //查询项目指导价
        $currentPrice = 0;
        $guidingPrice = 0;
        $projectGuidingPrice = $projectGuidingPriceData->getGuidingPrice($arr['type']);
        if (!empty($projectGuidingPrice)) {
            $guidingPrice = $projectGuidingPrice->project_guidingprice;
        }
        $projectInfo = $projectInfoData->getByNo($arr['type']);
        //查询相关模型id
        $modelData=new ModelData();
        $modelId=$modelData->getModelIdByModel($projectInfo);
        //查询图片
        $resourceIndexData = new ResourceIndexData;
        $imgUrl = $resourceIndexData->getUrl($modelId, $projectInfo->id, ResourceIndexData::OVERVIEW_IMG);

        //最低挂单价格和指导价取最大
        $currentPrice = $sellData->getCurrentPrice($arr['type']);
        // $arr['currentPrice'] = max($currentPrice, $guidingPrice);
        $arr['currentPrice'] = $guidingPrice;

        $arr['item']['cover_img1'] = $imgUrl;
        $arr['frozen'] = $forzenData->getCoinFrozens($arr['userid'], $arr['type']);
        //查询最新成交价
        $arr['order'] = $orderData->getInfo($arr['type']);
        $sysConfigs = $userTypeData->getData($this->session->userid);

        
        $arr['item']['itemName'] = $projectInfo->project_name;
        $arr['scale'] = $projectInfo->project_scale;

        $count = $arr['cash'] + $arr['pending'];
        $arr['valuation'] = $guidingPrice / $arr['scale'] * $count;
        $arr['order']['price'] *= $arr['scale'];

        $projectInfoArray = ['name', 'coinType', 'score', 'investsTypeid', 'type'];
        $project = $projectInfoAdapter->getDataContract($projectInfo, $projectInfoArray);
        //查询投资类型
        $investsTypeid = $project['investsTypeid'];
        $investsTypeDefine = $investsTypeDefineData->get($investsTypeid);
        $investsType = $investsTypeDefineAdapter->getDataContract($investsTypeDefine);
        //查询收益类型
        $proceeds = $projectData->getProceeds($arr['type']);
        //查询五年平均年华
        $annualRates = $projectData->getAnnualRates($arr['type']);

        //如果是新手专享项目 最新成交价改为指导价 增加累计收益
        $newUserProjectType = config("activity.newUserTypeid");
        $income = 0;
        if ($project['type'] == $newUserProjectType) {
            $arr['currentPrice'] = $guidingPrice;
            $arr['order']['price'] = floatval($guidingPrice);
            $income = $bonusItemData->getSumIncome($arr['type']);
        }
        $arr['income'] = $income;

        //增加结束时间
        $day = config('activity.endday');
        $endDate = $arr['date']->format('Y-m-d H:i:s');
        $arr['endDate'] = date('Y-m-d H:i:s', strtotime($endDate . "+$day day"));

        //查询项目类型
        $projectType = $projectTypeData->get($project['type']);
        $projectType = $projectTypeAdapter->getDataContract($projectType, ['id','name']);
        $arr['projectType'] = empty($projectType) ? [] : $projectType;

        //查询有多少人有这个代币
        $arr['coinUsers'] = $data->getCoinCountUsers($arr['type']);

        $arr['annualRate'] = $annualRates['value'];
        $arr['proceeds'] = false;
        foreach ($proceeds as $proceed) {
            $arr['proceeds'][] = $proceed['name'];
        }
        $arr['investsType'] = empty($investsType) ? false : $investsType;
        
        $buyCosts = $orderData->getBuyCosts($arr['type']);
        $arr['costs'] = $buyCosts;
        return $arr;
        
    }
}
