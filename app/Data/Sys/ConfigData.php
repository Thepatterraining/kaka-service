<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class ConfigData extends IDatafactory
{

    protected $modelclass = 'App\Model\Sys\Config';

    protected $no = 'config_key';
    

    /**
     * 获取系统配置列表
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.15
     */
    public function getConfigs()
    {
        $model = $this->modelclass;
        $res = $model::get();
        return $res;
    }


    public function getConfig($configKey)
    {
    }

    public function saveConfig($key, $value)
    {
        $model = $this->getByNo($key);
        $model->config_value = $value;
        $this->save($model);
        return $model;
    }
}
