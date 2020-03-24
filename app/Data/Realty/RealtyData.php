<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;
use App\Data\Region\DistrictData as RegionDistrictData;

    /**
     * 小区管理
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class RealtyData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\District';

    const BANLOU = '板楼';
    const TOWER = '塔楼';
    const BANLOU_TOWER = '板塔结合';

    const HOUSEWITHLIFT_YES = '有';
    const HOUSEWITHLIFT_NO = '无';

    private $housetypeName = '';
    private $housetypeBedroom = '';
    private $housetypeParlor = '';
    private $housetypeBathroom = '';
    private $housetypeFloor = 1;
    private $housetypeRemark = '';

    /**
     * 添加房源
     *
     * @param  $url url
     * @param  $title 标题
     * @param  $orderInfo 成交信息
     * @param  $dealTotalPrice 成交总价
     * @param  $price 成交单价
     * @param  $dataSpan 成交周期信息
     * @param  $baseInfo 基本信息
     * @param  $dataOrder 交易属性
     * @param  $districtRegionName 市区名称
     * @author zhoutao
     * @edate  2017.9.29
     */
    public function add($url, $title, $orderInfo, $dealTotalPrice, $price, $dataSpan, $baseInfo, $dataOrder, $districtRegionName)
    {
        $title = explode(' ', $title);
        $orderInfo = explode(' ', $orderInfo);
        preg_match("/(.*)\((.*)\)/", $baseInfo['houseFlow'], $houseFlow, PREG_OFFSET_CAPTURE);
        preg_match("/\d+/", $houseFlow[2][0], $houseBuildingHeight);
        preg_match("/(.*?)室(.*?)厅(.*?)厨(.*?)卫/", $baseInfo['housetype'], $houseType);
        
        $baseInfo['houseWithlift'] = $this->houseWithliftToBit($baseInfo['houseWithlift']);
        $dealTotalPrice = $this->tenThousandToElement($dealTotalPrice);
        $houseListprice = $this->tenThousandToElement($dataSpan['houseListprice']);
        $houseBuildingType = $this->houseBuildingTypeToDic($baseInfo['houseBuildingType']);
        $this->createHouse($url, $title, $orderInfo, $dealTotalPrice, $price, $dataSpan, $baseInfo, $dataOrder, $houseFlow, $houseBuildingHeight[0], $houseListprice, $houseBuildingType, $houseType, $districtRegionName);
        
    }

    /**
     * 是否有电梯转换
     *
     * @param  $houseWithlift 有 or 无
     * @author zhoutao
     * @date   2017.9.29
     */
    private function houseWithliftToBit($houseWithlift)
    {
        switch ($houseWithlift) {
        case self::HOUSEWITHLIFT_YES :
            $bit = 1;
            break;
        case self::HOUSEWITHLIFT_NO :
            $bit = 0;
            break;
        default :
            $bit = 0;
            break;
        }
        return $bit;
    }

    /**
     * 房屋类型转换
     *
     * @param  $houseBuildingType 房屋类型
     * @author zhoutao
     * @date   2017.9.29
     */
    private function houseBuildingTypeToDic($houseBuildingType)
    {
        switch ($houseBuildingType) {
        case self::BANLOU :
            $dic = HouseData::BUILDING_TYPE_BANLOU;
            break;
        case self::TOWER :
            $dic = HouseData::BUILDING_TYPE_TOWER;
            break;
        case self::BANLOU_TOWER :
            $dic = HouseData::BUILDING_TYPE_BANLOU_TOWER;
            break;
        default :
            $dic = HouseData::BUILDING_TYPE_BANLOU;
            break;
        }
        return $dic;
    }

    /**
     * 扩大一万倍
     *
     * @param  $amount 金额
     * @author zhoutao
     * @date   2017.9.29
     */
    private function tenThousandToElement($amount)
    {
        return $amount * 10000;
    }

    /**
     * 创建房源
     *
     * @param  $url url
     * @param  $title 标题
     * @param  $orderInfo 成交信息
     * @param  $dealTotalPrice 成交总价
     * @param  $price 成交单价
     * @param  $dataSpan 成交周期信息
     * @param  $baseInfo 基本信息
     * @param  $dataOrder 交易属性
     * @param  $houseFlow 楼层信息
     * @param  $houseBuildingHeight 楼层数
     * @param  $houseListprice 挂牌价
     * @param  $houseBuildingType 楼型
     * @param  $houseType 房屋类型
     * @param  $districtRegionName 市区名称
     * @author zhoutao
     * @edate  2017.9.29
     */
    private function createHouse($url, $title, $orderInfo, $dealTotalPrice, $price, $dataSpan, $baseInfo, $dataOrder, $houseFlow, $houseBuildingHeight, $houseListprice, $houseBuildingType, $houseType, $districtRegionName)
    {
        $district = $this->addDistrict($title[0], $districtRegionName);
        $houseDistrictid = $district->id;
        $houseType = $this->addHouseType($houseType);
        $houseTypeid = $houseType->id;
        $this->addHouse(
            $title[0], $orderInfo[0], $baseInfo['houseSize'], $price, $dealTotalPrice, $baseInfo['houseBuildingYear'], 1,
            $houseBuildingHeight, $baseInfo['houseWithlift'], $houseFlow[1][0], $houseListprice, $dataSpan['houseTransactionCycle'], 
            $houseBuildingType, $houseDistrictid, $baseInfo['houseInnersize'], $dataOrder['TransactionOwnership'], $dataOrder['houseHomelinkNo'], 
            $url, $houseTypeid
        );
    }

    /**
     * 插入小区
     *
     * @param  $districtName 小区名称
     * @param  $districtRegionid 市区名称
     * @author zhoutao
     * @date   2017.9.19
     */
    private function addDistrict($districtName, $districtRegionName)
    {
        //查询市区id
        $districtData = new RegionDistrictData;
        $districtRegionid = $districtData->getId($districtRegionName);

        $districtData = new DistrictData;
        $district = $districtData->add($districtName, $districtRegionid);
        return $district;
    }

    /**
     * 插入学区
     *
     * @param  $rsdName 学区名称
     * @param  $rsdShortname 学区简称
     * @param  $rsdDistrictid 市区id
     * @param  $rsdStartyear 设立年份
     * @param  $rsdEndyear 取消年份
     * @author zhoutao
     * @date   2017.9.19
     */
    private function addSchoolDistrict($rsdName, $rsdShortname, $rsdDistrictid, $rsdStartyear, $rsdEndyear)
    {
        $schoolDistrictData = new SchoolDistrictData;
        $schoolDistrict = $schoolDistrictData->add($rsdName, $rsdShortname, $rsdDistrictid, $rsdStartyear, $rsdEndyear);
        return $schoolDistrict->id;
    }

    /**
     * 关联小区和学区
     *
     * @param  $districtid 小区id
     * @param  $schoolDistrictid 学区id
     * @author zhoutao
     * @date   2017.9.19
     */
    private function addDistrictSchoolDistrictItem($districtid, $schoolDistrictid)
    {
        $districtSchoolDistrictItem = new DistrictSchoolDistrictItemData;
        $districtSchoolDistrictItem->add($districtid, $schoolDistrictid);
    }

    /**
     * 插入房源信息
     *
     * @param  $houseName 名称
     * @param  $houseTradedate 成交日期
     * @param  $houseSize 大小 以0.01为单位，即，如果为 50.06平，表示为5006
     * @param  $houseUnitprice 单价 以元为单位
     * @param  $housePrice 总价 以元为单位
     * @param  $houseBuildingYear 建设年份 1900-2100
     * @param  $houseOrientation 朝向 0000 分别表示东南西北
     * @param  $houseBuildingHeight 楼层数
     * @param  $houseWithlift 是否有电梯
     * @param  $houseFlow 楼层
     * @param  $houseListprice 挂牌价
     * @param  $houseTransactionCycle 成交周期
     * @param  $houseBuildingType 楼型 字典表building_type BT01 板楼 BT02 塔楼 BT03 板塔结合
     * @param  $houseDistrictid 小区id
     * @param  $houseDistrictName 小区名称
     * @param  $houseInnersize 套内面程
     * @param  $houseUse 用途
     * @param  $houseHomelinkNo 链家房源编号
     * @param  $houseHomelineAddress 链家房源地址
     * @param  $houseTypeid 户型id
     * @param  $houseTypeName 户型名称
     * @param  $houseSubwaystation 附近地铁
     * @param  $houseSubwaydistance 距离
     * @author zhoutao
     * @date   2017.9.19
     */
    private function addHouse($houseName, $houseTradedate, $houseSize, $houseUnitprice, $price, $houseBuildingYear, $houseOrientation, $houseBuildingHeight, $houseWithlift, $houseFlow, $houseListprice, $houseTransactionCycle, $houseBuildingType, $houseDistrictid, $houseInnersize, $houseUse, $houseHomelinkNo, $houseHomelineAddress, $houseTypeid)
    {
        $houseData = new HouseData;
        $houseData->add($houseName, $houseTradedate, $houseSize, $houseUnitprice, $price, $houseBuildingYear, $houseOrientation, $houseBuildingHeight, $houseWithlift, $houseFlow, $houseListprice, $houseTransactionCycle, $houseBuildingType, $houseDistrictid, $houseInnersize, $houseUse, $houseHomelinkNo, $houseHomelineAddress, $houseTypeid);
    }

    /**
     * 插入户型信息
     *
     * @param  $housetypeName 名称
     * @param  $housetypeBedroom 卧室数量
     * @param  $housetypeParlor 厅
     * @param  $housetypeBathroom 卫
     * @param  $housetypeFloor 层
     * @param  $housetypeRemark 备注
     * @author zhoutao
     * @date   2017.9.21
     */
    private function addHouseType($houseType)
    {
        if (count($houseType) > 3) {
            $this->housetypeName = $houseType[0];
            $this->housetypeBedroom = $houseType[1];
            $this->housetypeParlor = $houseType[2];
            $this->housetypeBathroom = $houseType[3];
        }

        $houseTypeData = new HouseTypeData;
        return $houseTypeData->add($this->housetypeName, $this->housetypeBedroom, $this->housetypeParlor, $this->housetypeBathroom, $this->housetypeFloor, $this->housetypeRemark);
    }

}
