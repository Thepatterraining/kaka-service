<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;

class NotifyGroupData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Notify\NotifyGroup';


    /**
     * 查询所有通道信息
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getNotifyGroup()
    {
        $model = $this->modelclass;
        return $model::get();
    }

    public function getClassName($id)
    {
        $groupInfo = $this->get($id);
        if (empty($groupInfo)) {
            return null;
        }
        return $groupInfo->group_name;
    }

    public function addNotifyGroup($groupName,$groupNote)
    {
        $item= $this->newitem();
        $item->group_name=$groupName;
        $item->group_note=$groupNote;
        $this->create($item);
        return $item;
    }

    public function saveNotifyGroup($item,$groupName,$groupNote)
    {
        $item->group_name=$groupName;
        $item->group_note=$groupNote;
        $this->save($item);
        return $item;
    }

    public function getClassById($id)
    {
        $model=$this->newitem();
        $groupInfo = $model->where('id', $id)->first();
        if (empty($groupInfo)) {
            return null;
        }
        return $groupInfo;
    }

    public function getGroup($name)
    {
        $model=$this->newitem();
        $groupInfo = $model->where('group_name', $name)->first();
        return $groupInfo;
    }

}
