<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddSysNews extends Controller
{

    protected $validateArray=array(
        "data.title"=>"required",
        "data.subtitle"=>"required",
        "data.writer"=>"required",
        "data.source"=>"required",
        "data.content"=>"required",
        "data.pushtype"=>"required|dic:newspush",
        "data.typeid"=>"required",
        "data.pushBanner"=>"required",
        "data.pushToTop"=>"required",
    );

    protected $validateMsg = [
        "data.title.required"=>"请输入标题!",
        "data.subtitle.required"=>"请输入副标题！",
        "data.writer.required"=>"请输入发布人！",
        "data.source.required"=>"请输入来源!",
        "data.content.required"=>"请输入内容！",
        "data.type.required"=>"请输入类型!",
        "data.pushtype.required"=>"请输入推送类型！",
        "data.refurl.required"=>"请输入指向url！",
        "data.outTime.required"=>"请输入下架时间!",
        "data.pushBanner.required"=>"请输入是否轮播!",
        "data.typeid.required"=>"请输入类型id!",
        "data.pushToTop.required"=>"请输入是否推送到首页!",
    ];

    /**
     * 添加新闻公告
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
        info(json_encode($this->request->all()));
        $data = new NewsData();
        $adapter = new NewsAdapter();

        //数据转换，赋值
        $newsInfo = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $newsInfo, $model);

        $typeid = $this->request->input('data.typeid');
        $pushToTop = $this->request->input('data.pushToTop');

        //赋值其他信息
        $res = $data->addNews($model, $typeid, $pushToTop);

        if ($res === false) {
            return $this->Error();
        }

        $this->Success('添加成功');
    }
}
