<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Realty\RealtyData;
use App\Data\Realty\HouseData;
use App\Data\Project\ProjectInfoData;
use App\Http\Adapter\Project\ProjectInfoAdapter;
use App\Data\Project\ProjectIsCoreItemData;
use App\Http\Adapter\Project\ProjectScoreItemAdapter;

class GetProjectScore extends Controller
{

    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
    ];


    /**
     * @api {post} token/project/getprojectscore 查询项目评分
     * @apiName getprojectscores
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
     *           'name' : '一号房产', //项目名称
     *           'coinType' : 'KKC-BJ0001', //代币类型
     *           'score' : '4.5', //总分
     *           'details' { //每项评分
     *               '租金回报' : 5,
     *               '升值空间' : 4,
     *               '地理位置' : 3,
     *               '交通便利' : 2,
     *               '教育属性' : 1,
     *           }
     *      }
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];

        $projectInfoData = new ProjectInfoData;
        $projectScoreData = new ProjectIsCoreItemData;
        $projectInfoAdapter = new ProjectInfoAdapter;
        $projectScoreItemAdapter = new ProjectScoreItemAdapter;

        //查询项目详细
        $projectInfo = $projectInfoData->getByNo($coinType);
        $projectInfoArray = ['name', 'coinType', 'score'];
        $project = $projectInfoAdapter->getDataContract($projectInfo, $projectInfoArray);

        //查询项目评分
        $projectScores = $projectScoreData->getScores($coinType);
        $scores = [];
        foreach ($projectScores as $projectScore) {
            $score = $projectScoreItemAdapter->getDataContract($projectScore);
            if (array_key_exists($score['name'], $scores) === false) {
                $scores[$score['name']] = floatval($score['score']);
            }
        }

        $res = [];
        $res = $project;
        $res['details'] = $scores;
        return $this->Success($res);
    }
}
