<?php

namespace App\Http\Controllers\News;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;

class GetSysNewsList extends Controller
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
     *
     * @api {post} user/getnewslist 查询公告列表
     * @apiName getnewslist
     * @apiGroup News
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
     *           "no" : "NC2017040611204698354"   公告号
     *           "title" : "北京半个月十二道"金牌"限购再无空隙可钻"  公告名称
     *           "intro" : "" 描述
     *           "time" : "04.06" 日期
     *           "img" : "img"
     *      }
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $data = new NewsData();
        $adapter = new NewsAdapter();
        $resourceIndexData = new ResourceIndexData;
        $where = $adapter->getFilers($request);
        $where['news_outime'] = ['>',date('Y-m-d H:i:s')];
        $order = ['news_time' => 'desc'];
        if (array_key_exists('news_pushtotop', $where)) {
            $order = ['news_pushtotop' => 'desc'];
        }
        $item = $data->query($where, $request['pageSize'], $request['pageIndex'], $order);

        $res = [];
        $modelData = new ModelData();
        $modelId = $modelData->getModelIdByModel($data->newitem());

        if (count($item['items']) > 0) {
            foreach ($item['items'] as $val) {
                $arr = $adapter->getDataContract($val, ['no','title','intro','time','id']);
                $arr['time'] = date('m.d', strtotime($arr['time']));
                //查询图片
                $imgUrl = $resourceIndexData->getUrl($modelId, $arr['id'], ResourceIndexData::NEWS_IMG);
                $arr['img'] = $imgUrl;
                $res[] = $arr;
            }
            $item['items'] = $res;
        }
        return $this->Success($item);
    }
}
