<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;

    /**
     * 房源管理
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class HouseData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\House';

    protected $no = 'house_homelink_no';

    const BUILDING_TYPE_BANLOU = 'BT01';
    const BUILDING_TYPE_TOWER = 'BT02';
    const BUILDING_TYPE_BANLOU_TOWER = 'BT03';

    private $houseSubwaystation = 0;
    private $houseSubwaydistance = 0;
    private $houseTypeName = '';
    private $houseDistrictName = '';

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
     * @param  $houseUse
     * @param  $houseHomelinkNo 链家房源编号
     * @param  $houseHomelineAddress 链家房源地址
     * @param  $houseTypeid 户型id
     * @param  $houseTypeName 户型名称
     * @param  $houseSubwaystation 附近地铁
     * @param  $houseSubwaydistance 距离
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($houseName, $houseTradedate, $houseSize, $houseUnitprice, $housePrice, $houseBuildingYear, $houseOrientation, $houseBuildingHeight, $houseWithlift, $houseFlow, $houseListprice, $houseTransactionCycle, $houseBuildingType, $houseDistrictid, $houseInnersize, $houseUse, $houseHomelinkNo, $houseHomelineAddress, $houseTypeid)
    {
        //查询小区名
        $districtData = new DistrictData;
        $houseDistrict = $districtData->get($houseDistrictid);
        if (!empty($houseDistrict)) {
            $this->houseDistrictName = $houseDistrict->district_name;
        }

        //查询户型名称
        $houseTypeData = new HouseTypeData;
        $houseType = $houseTypeData->get($houseTypeid);
        if (!empty($houseType)) {
            $this->houseTypeName = $houseType->housetype_name;
        }

        $model = $this->newitem();
        $model->house_name = strval($houseName);
        $model->house_tradedate = strval($houseTradedate);
        $model->house_size = intval($houseSize * 100);
        $model->house_unitprice = intval($houseUnitprice);
        $model->house_price = intval($housePrice);
        $model->house_building_year = intval($houseBuildingYear);
        $model->house_orientation = intval($houseOrientation);
        $model->house_building_height = $houseBuildingHeight;
        $model->house_withlift = $houseWithlift;
        $model->house_flow = $houseFlow;
        $model->house_listprice = $houseListprice;
        $model->house_transaction_cycle = $houseTransactionCycle;
        $model->house_building_type = $houseBuildingType;
        $model->house_district_id = $houseDistrictid;
        $model->house_district_name = $this->houseDistrictName;
        $model->house_innersize = intval($houseInnersize * 100);
        $model->house_use = $houseUse;
        $model->house_homelink_no = $houseHomelinkNo;
        $model->house_homeline_address = $houseHomelineAddress;
        $model->house_type_id = $houseTypeid;
        $model->house_type_name = $this->houseTypeName;
        $model->house_subwaystation = $this->houseSubwaystation;
        $model->house_subwaydistance = $this->houseSubwaydistance;
        $this->save($model);
    }

}
