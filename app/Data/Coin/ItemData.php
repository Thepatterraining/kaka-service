<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class ItemData extends IDatafactory
{

    protected $modelclass = 'App\Model\Coin\Item';


    /**
     * 查询项目
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     */
    public function getItem($coinType)
    {
        $where['kkbi'] = $coinType;
        return $this->find($where);
    }

    /**
     * 添加项目
     *
     * @param  $name 项目名
     * @param  $coinType 代币类型
     * @param  $region 地区
     * @param  $kkName 咔咔名称
     * @return mixed
     */
    public function addItem($name, $coinType, $region, $kkName)
    {
        $model = $this->newitem();
        $model->name = $name;
        $model->kkbi = $coinType;
        $model->region = $region;
        $model->kk_name = $kkName;
        return $model->save();
    }

    public function getInfo($coinType)
    {
        $items = $this->getItem($coinType);
        $arr['itemName'] = $items->name;
        $arr['itemRegion'] = $items->diqu;
        $arr['itemKkName'] = $items->kk_name;
        $arr['cover_img1'] = $items->cover_img1;
        $arr['itemCompound'] = $items->compound;
        $arr['itemLayout'] = $items->layout;
        $arr['itemPrice'] = $items->price;
        $arr['itemSpace'] = $items->space;
        $arr['changeDate'] = $items->exchange_time;
        $arr['itemSchool'] = $items->school_district;
        $arr['quarters1']['orderSpace'] = $items->order_space1;
        $arr['quarters1']['orderDate'] = $items->order_date1;
        $arr['quarters1']['orderLayout'] = $items->order_layout1;
        $arr['quarters1']['orderTotal'] = $items->order_total1;
        $arr['quarters2']['orderSpace'] = $items->order_space2;
        $arr['quarters2']['orderDate'] = $items->order_date2;
        $arr['quarters2']['orderLayout'] = $items->order_layout2;
        $arr['quarters2']['orderTotal'] = $items->order_total2;
        $arr['quarters3']['orderSpace'] = $items->order_space3;
        $arr['quarters3']['orderDate'] = $items->order_date3;
        $arr['quarters3']['orderLayout'] = $items->order_layout3;
        $arr['quarters3']['orderTotal'] = $items->order_total3;

        return $arr;
    }

    /**
     * 项目详情 查询项目信息
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function getItemInfo($coinType)
    {
        $itemInfo = $this->getItem($coinType);
        if ($itemInfo == null) {
            return false;
        }
        $res['coinType'] = $coinType;    //代币类型
        $res['price'] = $itemInfo->price;  //市场指导价
        $res['kkName'] = $itemInfo->kk_name; //代币名称
        $res['name'] = $itemInfo->name;   //项目名称
        $res['count'] = $itemInfo->amount; //资产总量
        $res['rose'] = $itemInfo->rose; //季度涨幅
        $res['date'] = $itemInfo->term; //资产周期
        $res['sublet'] = $itemInfo->sublet; //分租方式
        $res['changeDate'] = $itemInfo->exchange_time; //交割日期
        return $res;
    }

    /**
     * 项目详情  查询房产信息
     *
     * @param   $coinType  代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function getHouseInfo($coinType)
    {
        $itemInfo = $this->getItem($coinType);
        if ($itemInfo == null) {
            return false;
        }
        $res['compound'] = $itemInfo->compound; //小区名称
        $res['layout'] = $itemInfo->layout; //户型
        $res['region'] = $itemInfo->diqu . $itemInfo->trade;  //所属区域
        $res['number'] = $itemInfo->number;  //楼层
        $res['age'] = $itemInfo->age; //建设年代
        $res['space'] = $itemInfo->space; //面积
        $res['rowards'] = $itemInfo->rowards; //朝向
        $res['renovation'] = $itemInfo->renovation; //装修
        $res['school'] = $itemInfo->school; //教育配套
        $res['metro'] = $itemInfo->metro; // 地铁
        $res['layoutImg'] = $itemInfo->cover_img2; //户型图
        //同小区成交纪录
        $res['quarters1']['orderSpace'] = $itemInfo->order_space1;
        $res['quarters1']['orderPrice'] = $itemInfo->order_price1;
        $res['quarters1']['orderDate'] = $itemInfo->order_date1;
        $res['quarters1']['orderLayout'] = $itemInfo->order_layout1;
        $res['quarters1']['orderTotal'] = $itemInfo->order_total1;
        $res['quarters2']['orderSpace'] = $itemInfo->order_space2;
        $res['quarters2']['orderPrice'] = $itemInfo->order_price2;
        $res['quarters2']['orderDate'] = $itemInfo->order_date2;
        $res['quarters2']['orderLayout'] = $itemInfo->order_layout2;
        $res['quarters2']['orderTotal'] = $itemInfo->order_total2;
        $res['quarters3']['orderSpace'] = $itemInfo->order_space3;
        $res['quarters3']['orderDate'] = $itemInfo->order_date3;
        $res['quarters3']['orderPrice'] = $itemInfo->order_price3;
        $res['quarters3']['orderLayout'] = $itemInfo->order_layout3;
        $res['quarters3']['orderTotal'] = $itemInfo->order_total3;
        return $res;
    }

    /**
     * 查询投资分析
     *
     * @param   $coinType 代币类型
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function getInvestInfo($coinType)
    {
        $itemInfo = $this->getItem($coinType);
        if ($itemInfo == null) {
            return false;
        }
        $res['investment'] = htmlspecialchars($itemInfo->investment); //投资分析文字
        $res['investImg'] = $itemInfo->cover_img3;  //趋势图
        $res['invest_file'] = $itemInfo->plan_file; //文件uri
        $res['invest_file_name'] = $itemInfo->plan_file_name; //文件名
        return $res;
    }
}
