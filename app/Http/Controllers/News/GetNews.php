<?php

namespace App\Http\Controllers\News;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetNews extends Controller
{
    /**
     * @api {post} token/sys/getnews 首页查询公告
     * @apiName getnews
     * @apiGroup News
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : 'token'
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
     *              no        : 'NC2017110316035826218', //'编号'
     *              title     : '标题', //'标题'
     *              time      : '2017-11-03 16:03:58', //时间
     *              imgUrl    : 'url' //图片的url
     *      }   
     *  }
     */
    protected function run()
    {
        $request = $this->request->all();
        $data = new NewsData();
        $adapter = new NewsAdapter();

        $news = $data->getHomeNews();
        $newsArray = ['no','title','time'];
        $res = [];
        foreach ($news as $new) {
            $arr = $adapter->getDataContract($new, $newsArray);
            
            //查找配图
            $imgUrl = 'url';

            $res['imgUrl'] = $imgUrl;
            $res[] = $arr;
        }

        $this->success($res);
    }
}
