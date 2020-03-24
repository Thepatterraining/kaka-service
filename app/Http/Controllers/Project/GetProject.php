<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Realty\RealtyData;
use App\Data\Realty\HouseData;
use App\Data\Project\ProjectData;
use App\Data\Project\ProjectInfoItemData;
use App\Http\Adapter\Project\ProjectInfoItemAdapter;

class GetProject extends Controller
{

    const HOUSING_ESTATE = '小区名称';

    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
    ];


    /**
     * @api {post} token/project/getproject 查询项目详情
     * @apiName getproject
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型 KKC-BJ0001
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinType : 'KKC-BJ0001'
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
     *       'name' : '一号房产', //项目名
     *       'coinType' : 'KKC-BJ0001', //代币类型
     *       'score' : '4.5', //总评分
     *       'scale' : '0.01', //比例因子
     *       'currentPrice' : '1550', //最佳买入价格
     *       'holdLast' : 7, //持有年限
     *       'img_url' : '/upload/img.jpg', //图片
     *       'tags' : { //标签
     *           '帝都核心',
     *           '教育资源',
     *       },
     *       'status' : { //状态
     *           'id' : 1,
     *           'name' : '显示活动',
     *       },
     *       'investsType' : { //投资类型
     *           'id' : 1,
     *           'name' : '稳健型',
     *           'note' : '风险小，收益低',
     *       },
     *       'proceeds' : { //收益类型
     *           {
     *           'id' : 1,
     *           'name' : '浮动收益',
     *           'note' : '房产价值上浮交易收益',
     *           },
     *           {
     *           'id' : 2,
     *           'name' : '浮动收益',
     *           'note' : '房产价值上浮交易收益',
     *           },
     *       },
     *       'details' : { //项目信息
     *           {
     *               'group' : '房产信息',
     *               'items': {
     *                   {
     *                   'name' : '房屋类型',
     *                   'value' : '一室一厅',
     *                   'pre' : '',
     *                   'suf' : '',
     *                   },
     *                   {
     *                   'name' : '交通',
     *                   'value' : '',
     *                   'pre' : '',
     *                   'suf' : '',
     *                   },
     *                   {
     *                   'name' : '大小',
     *                   'value' : '55.5',
     *                   'pre' : '',
     *                   'suf' : '平米',
     *                   },
     *               }
     *           },
     *       },
     *      'housingEstateName' : '双旗杆' //小区名称
     *       'bonusInfo' : { //分红信息
     *           'name' : '租金分红',
     *           'bonusCyc' : {
     *               {
     *                   'name' : '按月',
     *                   'select' : false,
     *               },
     *               {
     *                   'name' : '按季',
     *                   'select' : true,
     *               },
     *               {
     *                   'name' : '按年',
     *                   'select' : false,
     *               }
     *           }
     *           'bonusPeriods' : 8,
     *           'rightConform' : '季度结束的最后一天',
     *           'rightDiviend' : '季度开始的第一天',
     *           'bonusRate' : '公示为准',
     *       },
     *      'annualrate' : { //年化收益
     *           'value' : '200%',
     *           'history' : {
     *               {
     *                   'year' : '2016',
     *                   'rate' : '160.66%',
     *               },
     *               {
     *                   'year' : '2017',
     *                   'rate' : '140%'
     *               },
     *           },
     *       },
     *      }
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];

        $projectData = new ProjectData;
        $projectInfoItemData = new ProjectInfoItemData;

        $projectInfoItemAdapter = new ProjectInfoItemAdapter;

        $res = $projectData->getProject($coinType);

        //在详细信息里面删除小区名称
        foreach ($res['details'] as $key => $details) {
            foreach ($details['items'] as $col => $val) {
                if ($val['name'] == self::HOUSING_ESTATE) {
                    unset($res['details'][$key]['items'][$col]);
                }
            }
        }

        //查询小区名称
        $housingEstateName = '';
        $projectHousingEstate = $projectInfoItemData->getItemByName($coinType, self::HOUSING_ESTATE);
        if (!empty($projectHousingEstate)) {
            $housingEstate = $projectInfoItemAdapter->getDataContract($projectHousingEstate);
            $housingEstateName = $housingEstate['value'];
        }
        
        $res['housingEstateName'] = $housingEstateName;

        return $this->Success($res);
    }
}
