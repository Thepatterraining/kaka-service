<?php
namespace App\Data\Item;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class InfoData extends IDatafactory
{

    protected $modelclass = 'App\Model\Item\Info';


    /**
     * 查询项目
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     */
    public function getItem($coinType)
    {
        $where['coin_type'] = $coinType;
        return $this->find($where);
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
            return null;
        }
        $res = $itemInfo->investment; //投资分析文字
        return $res;
    }

    /**
     * 卖单列表上面查询信息
     *
     * @param   $coinType 代币类型
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.31
     */
    public function getInfo($coinType)
    {
        $itemInfo = $this->getItem($coinType);
        if ($itemInfo == null) {
            return null;
        }
        $arr['itemName'] = $itemInfo->name;
        $arr['itemRegion'] = $itemInfo->diqu;
        $arr['itemKkName'] = $itemInfo->kk_name;
        $arr['itemCompound'] = $itemInfo->compound;
        $arr['itemLayout'] = $itemInfo->layout;
        $arr['itemPrice'] = $itemInfo->price;
        $arr['itemSpace'] = $itemInfo->space;
        $arr['changeDate'] = $itemInfo->exchange_time;
        $arr['itemSchool'] = $itemInfo->school_district;
        $arr['itemTerm'] = $itemInfo->term;
        $arr['rose'] = $itemInfo->rose;
        return $arr;
    }

    /**
     * 修改项目指导价
     *
     * @param  $coinType 代币类型
     * @param  $guidePrice 指导价
     * @author zhoutao
     */
    public function saveGuidePrice($coinType,$guidePrice)
    {
        $info = $this->getItem($coinType);
        if (empty($info)) {
            return false;
        }
        $info->price = $guidePrice;
        $this->save($info);
        return $info;
    }

    /**
     * 查询项目的代币类型
     *
     * @param  $id id
     * @author zhoutao
     * @date   2017.8.21
     */ 
    public function getCoinType($id)
    {
        $info = $this->get($id);
        if (empty($info)) {
            return '';
        }

        return $info->coin_type;
    }

    /**
     * 查询可交易区间
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function getInterval($coinType)
    {
        $res['startInterval'] = 0;
        $res['endInterval'] = 0;
        $info = $this->getItem($coinType);
        if (empty($info)) {
            return $res;
        }

        $res['start'] = intval(bcmul($info->price, 0.85, 2));
        $res['end'] = intval(bcmul($info->price, 1.15, 2));
        return $res;
    }

    /**
     * 判断价格在可交易区间
     *
     * @param  $coinType 代币类型
     * @param  $price 价格
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 增加了等于判断
     * @author zhoutao
     * @date   2017.9.5
     */ 
    public function checkInterval($coinType, $price)
    {
        $interval = $this->getInterval($coinType);
        if (bccomp($interval['start'], $price, 2) === 1 || bccomp($price, $interval['end'], 2) === 1) {
            return false;
        }
        return true;
    }

    /**
     * 查询项目上线时间
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.11
     */ 
    public function getStartTime($coinType)
    {
        $info = $this->getItem($coinType);
        if (empty($info)) {
            return date('Y-m-d');
        }
        return $info->starttime;
    }
}
