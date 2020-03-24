<?php
namespace App\Data\Item;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class FormulaData extends IDatafactory
{

    public static $FORMULA_LAYOUT_IMG_TYPE = 'IFT02'; //户型图
    public static $FORMULA_ITEM_IMG_TYPE = 'IFT03'; //项目图片
    public static $FORMULA_INVEST_TYPE = 'IFT04'; //投资分析
    public static $FORMULA_NOTARIAL_DOCUMENT_IMG_TYPE = 'IFT07'; //公证文件
    public static $FORMULA_LOCATION_MAP_IMG_TYPE = 'IFT08'; //外景图
    public static $FORMULA_INTERIOR_MAP_IMG_TYPE = 'IFT09'; //内景图
    const FORMULA_WECHAT_ITEM_IMG_TYPE = 'IFT12'; //微信项目图片
    

    protected $modelclass = 'App\Model\Item\Formula';

    /**
     * 查询户型图 图片地址
     *
     * @param   $coinType 代币类型
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getLayoutImg($coinType, $type)
    {
        $where['coin_type'] = $coinType;
        $where['type'] = $type; //户型图
        $info = $this->find($where);
        if ($info == null) {
            return null;
        }
        return $info->iamge;
    }

    /**
     * 查询投资分析图片 和文件
     *
     * @param   $coinType 代币类型
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getInvestInfo($coinType)
    {
        $where['coin_type'] = $coinType;
        $where['type'] = $this::$FORMULA_INVEST_TYPE; //投资分析
        $info = $this->find($where);
        if ($info == null) {
            $res['investImg'] = null;
            $res['invest_file'] = null;
            $res['invest_file_name'] = null;
            return $res;
        }
        $res['investImg'] = $info->iamge;
        $res['invest_file'] = $info->file;
        $res['invest_file_name'] = $info->file_name;
        return $res;
    }

    /**
     * 查询项目图 图片地址
     *
     * @param   $coinType 代币类型
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getItemImg($coinType, $type)
    {
        $model = $this->newitem();
        $where['coin_type'] = $coinType;
        $where['type'] = $type; //项目图
        $info = $model->where($where)->get();
        if ($info->isEmpty()) {
            return [];
        }
        foreach ($info as $v) {
            $res[] = $v->iamge;
        }
        return $res;
    }

    /**
     * 查询证照公式
     *
     * @param   $coinType 代币类型
     * @param   $type 图片类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getFormula($coinType, $type)
    {
        $where['coin_type'] = $coinType;
        $where['type'] = $type; //户型图
        $model = $this->newitem();
        $res = $model->where($where)->get();
        //        dump($res);die;
        if ($res->isEmpty()) {
            return [];
        }
        return $res;
    }
}
