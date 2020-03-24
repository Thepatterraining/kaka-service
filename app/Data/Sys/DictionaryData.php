<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class DictionaryData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\Dictionary';

     
    public function getDictionaries($dictype)
    {
        $modelclass = $this->modelclass;
        return $modelclass::where(
            array(
            "dic_type"=>$dictype
        
            )
        )->get();
    }
    
    public function getDictionary($dictype, $dicvalue)
    {
        $modelclass = $this->modelclass;
        return $modelclass::where(
            array(
            "dic_type"=>$dictype,
            "dic_no"=>$dicvalue
            )
        )->first();
    }

    /**
     * 删除字典表
     *
     * @param   $no no
     * @param   $type type
     * @authro  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function delDic($no, $type)
    {
        $where['dic_no'] = $no;
        $where['dic_type'] = $type;
        $model = $this->newitem();
        $model->where($where)->delete();
    }
}
