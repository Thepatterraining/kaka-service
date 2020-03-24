<?php

namespace App\Http\Controllers\News;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSysNewsInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:news",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入公告编号",
    ];

    /**
     *
     * @api {post} user/getnewsinfo 查询公告详情
     * @apiName getnewsinfo
     * @apiGroup News
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     * @apiParam {string} no 公告号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : token
     *      no : 'NC2017040611204698354'
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
     *           "time" : "2017-04-06 11:20:46" 时间
     *           "writer" : "澎湃新闻" 发布人
     *           "source" : "房天下" 来源
     *           "content" : "" 内容
     *           "type" : {
     *              "no" : "NEWS01"
     *              "name" : "行业新闻"
     *           }
     *           "pushtype" : {
     *              "no" : "NP01"
     *              "name" : "弹窗"
     *           }
     *           "remodel" : "" 指向业务
     *           "refno" : "" 指向单据号
     *           "refurl" : "" 指向URL
     *           "left" : "" 上一篇
     *           "right" : "" 下一篇
     *      }
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $no = $request['no'];
        $data = new NewsData();
        $adapter = new NewsAdapter();
        $info = $data->getByNo($no);
        $res = [];
        $res['left'] = '';
        $res['right'] = '';
        if ($info != null) {
            $res = $adapter->getDataContract($info);

            $res['left'] = $data->getLeft($info);
            
            $res['right'] = $data->getRight($info);
        }

        

        return $this->Success($res);
    }
}
