<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionSellData;
use App\Data\Realty\RealtyData;
use App\Data\Realty\HouseData;
use App\Data\Project\ProjectInfoData;
use App\Http\Adapter\Project\ProjectInfoAdapter;
use App\Data\Project\ProjectData;
use App\Data\Project\ProjectStatusData;
use App\Http\Adapter\Project\ProjectStatusAdapter;
use App\Data\Project\ProjectInvestsTypeDefineData;
use App\Http\Adapter\Project\ProjectInvestsTypeDefineAdapter;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Project\ProjectIsCoreItemData;
use App\Http\Adapter\Project\ProjectScoreItemAdapter;
use App\Data\Sys\ModelData;
use App\Data\Project\ProjectTypeData;
use App\Http\Adapter\Project\ProjectTypeAdapter;
use App\Data\User\UserData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\Project\ProjectGuidingPriceData;

class GetProjects extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];


    /**
     * @api {post} token/project/getprojectlist 查询项目列表
     * @apiName getprojectlist
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : 1,
     *      pageSize  : 10
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *          'pageSize' : 10,
     *          'pageIndex' : 1,
     *          'pageCount' : 1,
     *          'totalSize' : 10,
     *          'items' : {
     *              0 : {
     *                  'type' : {
     *                      'id' : 1,
     *                      'name' : 商品房, 
     *                  },
     *                  'name' : '一号房产', //项目名
     *                  'coinType' : 'KKC-BJ0001', //代币类型
     *                  'annualRate' : '35.5%',  //年华收益
     *                  'scale' : '0.01', //比例因子
     *                  'currentPrice' : '1550', //最佳买入价格
     *                  'score' : '4.5', //总评分
     *                  'proceeds' { //收益类型
     *                      '浮动收益',
     *                      '固定分红',
     *                  },
     *                  'status' : { //状态
     *                      'id' : 1,
     *                      'name' : '限时活动',
     *                  },
     *                  'investsType' : { //投资类型
     *                      'id' : 1,
     *                      'name' : '稳健型',
     *                  },
     *                  'img_url' => 'img_url.jpg', //图片
     *                  'scoreDetails' { //每项评分
     *                      '租金回报' : 5,
     *                      '升值空间' : 4,
     *                      '地理位置' : 3,
     *                      '交通便利' : 2,
     *                      '教育属性' : 1,
     *                  }
     *              },...
     *          }
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $pageSize = $this->request->input("pageSize");
        $pageIndex = $this->request->input("pageIndex");

        $userCoin = new UserCoinAccountData();
        $userData = new UserData;
        $projectData = new ProjectData;
        $projectInfoData = new ProjectInfoData;
        $sellData = new TranactionSellData;
        $projectStatusData = new ProjectStatusData;
        $investsTypeDefineData = new ProjectInvestsTypeDefineData;
        $projectTypeData = new ProjectTypeData;
        $projectInfoAdapter = new ProjectInfoAdapter;
        $projectStatusAdapter = new ProjectStatusAdapter;
        $investsTypeDefineAdapter = new ProjectInvestsTypeDefineAdapter; 
        $projectScoreData = new ProjectIsCoreItemData;
        $projectScoreItemAdapter = new ProjectScoreItemAdapter;
        $projectTypeAdapter = new ProjectTypeAdapter;
        $projectGuidingPriceData = new ProjectGuidingPriceData;

        $filters = $projectInfoAdapter->getFilers($request);
        $orderBy = [
            'project_current_status_index' => 'desc',
            'project_status_start' => 'desc',
            'id' => 'desc',
        ];
        $projects = $projectInfoData->query($filters, $pageSize, $pageIndex, $orderBy);
        $modelData = new ModelData();
        $modelId = $modelData->getModelIdByModel($projectInfoData->newitem());
        $projectArray = ['name','coinType','score','scale','investsTypeid','id','type'];

        $res = [];
        foreach ($projects['items'] as $project) {
            $project = $projectInfoAdapter->getDataContract($project, $projectArray);
            $coinType = $project['coinType'];
            $projectid = $project['id'];
            //查询五年平均年华
            $annualRates = $projectData->getAnnualRates($coinType);
            //查询最佳买入价格
            $currentPrice = $sellData->getCurrentPrice($coinType);
            //查询项目状态
            $projectStatus = $projectStatusData->getStartStatusByNo($coinType);
            $status = $projectStatusAdapter->getDataContract($projectStatus);
            //查询收益类型
            $proceeds = $projectData->getProceeds($coinType);
            //查询投资类型
            $investsTypeid = $project['investsTypeid'];
            $investsTypeDefine = $investsTypeDefineData->get($investsTypeid);
            $investsType = $investsTypeDefineAdapter->getDataContract($investsTypeDefine);
            //查询图片
            $resourceIndexData = new ResourceIndexData;
            $imgUrl = $resourceIndexData->getUrl($modelId, $projectid, ResourceIndexData::OVERVIEW_IMG);
            //查询评分
            $projectScores = $projectScoreData->getScores($coinType);
            $scores = [];
            foreach ($projectScores as $projectScore) {
                $score = $projectScoreItemAdapter->getDataContract($projectScore);
                if (array_key_exists($score['name'], $scores) === false) {
                    $scores[$score['name']] = floatval($score['score']);
                }
            }
            //查询类型
            $type = [];
            $projectType = $projectTypeData->get($project['type']);
            $type = $projectTypeAdapter->getDataContract($projectType, ['id','name']);

            $project['type'] = $type;
            $project['scoreDetails'] = $scores;
            $project['status']['id'] = array_get($status, 'statusid', 0);
            $project['status']['name'] = array_get($status, 'statusName', '');
            $project['currentPrice'] = $currentPrice;
            $project['annualRate'] = $annualRates['value'];
            $project['investsType'] = $investsType;
            $project['img_url'] = $imgUrl;
            foreach ($proceeds as $proceed) {
                $project['proceeds'][] = $proceed['name'];
            }

            $userid = $this->session->userid;
            $newUserCoinType = config("activity.newUserCoin");
            if ($coinType == $newUserCoinType) {
                $guidingPrice = $projectGuidingPriceData->getGuidingPrice($coinType);
                $project['currentPrice'] = floatval($guidingPrice->project_guidingprice);
                if ($userid > 0) {
                    $user = $userData->getUser($userid);
                    $regTime = $user->created_at->format('Y-m-d H:i:s');
                    $qualiTime = config("activity.date");
                    //新用户显示
                    if ($regTime >= $qualiTime) {
                        //查询用户有没有这个币种
                        $newUserCoinType = config("activity.newUserCoin");
                        $userCoinInfo = $userCoin->getUserCoin($newUserCoinType, $userid);
                        //没参加过显示
                        if (empty($userCoinInfo)) {
                            $res[] = $project;
                        } else {
                            //正在参加显示
                            $cash = $userCoinInfo->usercoin_cash;
                            $pending = $userCoinInfo->usercoin_pending;
                            if ($cash + $pending > 0) {
                                $res[] = $project;
                            }
                        }

                        
                    }
                } else {
                    $res[] = $project;
                }
            } else {
                $res[] = $project;
            }
            
        }
        $projects['items'] = $res;

        return $this->Success($projects);
    }
}
