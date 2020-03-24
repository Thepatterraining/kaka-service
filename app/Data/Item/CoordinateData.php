<?php
namespace App\Data\Item;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class CoordinateData extends IDatafactory
{

    protected $modelclass = 'App\Model\Item\Coordinate';

    protected $no = 'coin_type';

    const HOUSE_TYPE = 'IC01';
    const SCHOOL_TYPE = 'IC02';

    /**
     * 查询房产坐标
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     */
    public function getHouse($coinType)
    {
        $where['coin_type'] = $coinType;
        $where['type'] = CoordinateData::HOUSE_TYPE;

        $model = $this->modelclass;
        $info = $model::where($where)->first();
        return $info;
    }

    /**
     * 查询学校坐标
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     */
    public function getSchools($coinType)
    {
        $where['coin_type'] = $coinType;
        $where['type'] = CoordinateData::SCHOOL_TYPE;

        $model = $this->modelclass;
        $schoolCoordinates = $model::where($where)->orderBy('sort')->get();
        return $schoolCoordinates;
    }


}
