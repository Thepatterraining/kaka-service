<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class NewsAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"news_no"
        ,"title"=>"news_title"
        ,"subtitle"=>"news_subtitle"
        ,"writer"=>"news_writer"
        ,"source"=>"news_source"
        ,"content"=>"news_content"
        ,"time"=>"news_time"
        ,"type"=>"news_type"
        ,"pushtype"=>"news_pushtype"
        ,"remodel"=>"news_refmodel"
        ,"refno"=>"news_refno"
        ,"refurl"=>"news_refurl"
        ,"intro"=>"news_intro"
        ,"outTime"=>"news_outime"
        ,"pushBanner"=>"news_pushbanner"
        ,"typeid"=>"news_type_id"
        ,"typeName"=>"news_type_name"
        ,"pushToTop"=>"news_pushtotop"
    ];

    protected $dicArray = [
        "type"=>"news",
        "pushtype"=>"newspush",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
