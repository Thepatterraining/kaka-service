<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveNews extends Controller
{

    protected $validateArray=[
        "no"=>"required|doc:news",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入公告编号",
    ];

    /**
     * 修改新闻公告
     *
     * @param   title 标题
     * @param   subtitle 副标题
     * @param   writer 发布人
     * @param   source 来源
     * @param   content 内容
     * @param   type 类型
     * @param   pushtype 推送类型
     * @param   remodel 指向业务
     * @param   refno 指向单据号
     * @param   refurl 指向url
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.25
     */
    public function run()
    {
        $data = new NewsData();
        $adapter = new NewsAdapter();
        $no = $this->request->input('no');

        //数据转换，赋值
        $newsInfo = $adapter->getData($this->request);
        $model = $data->getByNo($no);
        $adapter->saveToModel(false, $newsInfo, $model);
        $res = $model->save();

        $this->Success('修改成功');
    }
}
