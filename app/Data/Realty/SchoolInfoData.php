<?php
namespace App\Data\Realty;

use App\Data\IDataFactory;

    /**
     * 学校信息
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class SchoolInfoData extends IDatafactory
{
    protected $modelclass = 'App\Model\Realty\SchoolInfo';

    /**
     * 插入学校信息
     *
     * @param  $schoolName 学校名
     * @param  $schoolRunningType 学校简称
     * @param  $schoolType 学校类型 SCHT01 小学 SCHT02 初中 SCHT03 高中 SCHT04 九年一贯
     * @param  $schoolIntro 学校介绍 
     * @author zhoutao
     * @date   2017.9.19
     */
    public function add($schoolName, $schoolRunningType, $schoolType, $schoolIntro)
    {
        $model = $this->newitem();
        $model->school_name = $schoolName;
        $model->school_running_type = $schoolRunningType;
        $model->school_type = $schoolType;
        $model->shool_intro = $schoolIntro;
        $this->save($model);
    }

}
