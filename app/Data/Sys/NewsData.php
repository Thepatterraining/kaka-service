<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class NewsData extends IDatafactory
{

    protected $modelclass = 'App\Model\Sys\News';

    protected $no = "news_no";

    /**
     * 添加公告
     *
     * @param   $model model
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.25
     * 
     * 增加类型和首页推送参数
     * @param   $typeid 类型id
     * @param   $pushToTop 是否推送首页
     * @author  zhoutao
     * @date    2017.11.3
     */
    public function addNews($model, $typeid, $pushToTop)
    {
        $newsTypeData = new NewsTypeData;
        $newsType = $newsTypeData->get($typeid);
        if (!empty($newsType)) {
            $doc = new DocNoMaker();
            $no = $doc->Generate('NC');
            $model->news_time = date('Y-m-d H:i:s');
            $model->news_no = $no;
            $model->news_type_id = $newsType->id;
            $model->news_type_name = $newsType->newstype_name;
            if ($pushToTop > 0) {
                $preToTop = $this->getPrePushToTop();
                $model->news_pushtotop = $preToTop + 1;
            }
            return $this->create($model);
        }
        
    }

    /**
     * 查询最后一条推送首页的index
     *
     * @author zhoutao
     * @date   2017.11.3
     */
    private function getPrePushToTop()
    {
        $model = $this->modelclass;
        $info = $model::orderBy('news_pushtotop', 'desc')->first();
        if (!empty($info)) {
            return $info->news_pushtotop;
        }
        return 0;
    }

    /**
     * 查询上一遍公告
     *
     * @param   $info 公告内容
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function getLeft($info)
    {
        $model = $this->newitem();
        $left = $model->where('id', '<', $info->id)
            ->where('news_type', $info->news_type)
            ->orderBy('id', 'desc')
            ->first();
        if ($left == null) {
            return null;
        }
        return $left->news_no;
    }

    /**
     * 查询下一篇公告
     *
     * @param   $info 公告内容
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function getRight($info)
    {
        $model = $this->newitem();
        $right = $model->where('id', '>', $info->id)
            ->where('news_type', $info->news_type)
            ->orderBy('id', 'asc')
            ->first();
        if ($right == null) {
            return null;
        }
        return $right->news_no;
    }

    /**
     * 删除公告
     *
     * @param  $no  公告号
     * @author zhoutao
     * @date   2017.9.21
     */
    public function deleteNews($no)
    {
        $model = $this->modelclass;
        return $model::where('news_no', $no)->delete();
    }

    /**
     * 查询首页的三条公告
     *
     * @author zhoutao
     * @date   2017.11.3
     */
    public function getHomeNews()
    {
        $model = $this->modelclass;
        return $model::where('news_pushtotop', '>', 0)
                ->where('news_outime', '>', date('Y-m-d H:i:s'))
                ->orderBy('news_pushtotop', 'desc')
                ->limit(3)
                ->get();
    }

    /**
     * 查询滚动的
     *
     * @author zhoutao
     * @date   2017.11.3
     */
    public function getHomeScrollNews()
    {
        $model = $this->modelclass;
        return $model::where('news_pushbanner', 1)
                ->where('news_outime', '>', date('Y-m-d H:i:s'))
                ->orderBy('news_time', 'desc')
                ->get();
    }
}
