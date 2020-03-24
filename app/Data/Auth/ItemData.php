<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class ItemData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\Item';

    const MENU_TYPE = 'AU01';
    const VIEW_TYPE = 'AU02';
    const OPER_TYPE = 'AU03';
    const FILED_TYPE = 'AU04';
    const FUNC_TYPE = 'AU05';

    /**
     * 写入权限表
     *
     * @param $no  编号
     * @param $name 名称
     * @param $url url
     * @param $type 类型
     * @param $notes 备注
     */
    public function add($no, $name, $url, $type, $notes)
    {
        $model = $this->newitem();
        $model->auth_no = $no;
        $model->auth_name = $name;
        $model->auth_url = $url;
        $model->auth_type = $type;
        $model->auth_notes = $notes;
        $this->create($model);
    }

    public function createAuth($parentNo, $name, $url, $type, $notes)
    {
        $no = empty($parentNo) ? 001 : $parentNo . 001;
        $this->add($no, $name, $url, $type, $notes);
    }

    public function getAuth($url)
    {
        $where['auth_url'] = $url;
        
        $model = $this->modelclass;
        return $model::where($where)->first();
    }

}
