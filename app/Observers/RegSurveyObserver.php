<?php
namespace App\Observers;
// use App\Data\Notify\DefineData;

class RegSurveyObserver extends ModelObserver{

    protected $event_queue="";
    
    /**
     * 监听注册操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date 2017.11.22
     */
    public function created($data)
    {
        $queueData=(object)array();

        $this->createdHandle($data,$queueData);    
    }

}