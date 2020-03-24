<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Data\Auth\AccessToken;

class ApplicationData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Sys\Application';

    protected $no = 'app_id';

    /**
     * 创建应用
     *
     * @param  $name 名称
     * @param  $version 版本
     * @param  $remark 说明
     * @author zhoutao
     * @date   2017.11.7
     */
    public function add($name, $version, $remark)
    {
        $tokenFac = new AccessToken;
        $appSecrect = DocNoMaker::getRandomString(16);
        $appid = $tokenFac->create_guid('appid');
        $model = $this->newitem();
        $model->app_name = $name;
        $model->app_version = $version;
        $model->app_remark = $remark;
        $model->app_id = $appid;
        $model->app_key = md5($appid . md5($appid . $appSecrect));
        $array = [
            "app_name"=>$name
        ];
        if($this->getFirst($array)!=null){
            throw new \Exception("已经存在");
        }
        $this->create($model);
        $res['appid'] = $appid;
        $res['appSecrect'] = $appSecrect;
        return $res;
    }
    /**
     * 验证app_secrect
     *
     * @param  $appid appid
     * @param  $appSecrect app_secrect
     * @author zhoutao
     * @date   2017.11.7
     */
    public function checkAppSecrect($appid, $appSecrect)
    {
        $app = $this->getByNo($appid);
        if (empty($app)) {
            return false;
        }
        return $app->app_key == md5($appid . md5($appid . $appSecrect));
    }
}
