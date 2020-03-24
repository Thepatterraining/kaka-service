<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class MessageData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\Message';

    /**
     * 把消息状态改成推送
     *
     * @param   $id
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function savePushStatus($id)
    {
        $info = $this->get($id);
        $info->msg_status = 'MSG02';
        $info->msg_pushtime = date('Y-m-d H:i:s');
        $this->save($info);
    }

    /**
     * 把消息状态改成已读
     *
     * @param   $status 状态
     * @param   $no 编号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function saveReadStatus($status, $no)
    {
        $where['msg_status'] = $status;
        $where['msg_no'] = $no;
        $info = $this->find($where);
        if ($info == null) {
            return null;
        }
        $date = date('Y-m-d H:i:s');
        $info->msg_status = 'MSG03';
        $info->msg_readtime = $date;
        $this->save($info);
        return $date;
    }

    /**
     * 删除用户所有消息
     *
     * @param   null $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function delMessage($userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $model = $this->newitem();
        $where['msg_to'] = $userid;
        $res = $model->where($where)->delete();
        return $res;
    }

    /**
     * 查询用户消息数量
     *
     * @param   $status 状态
     * @param   null          $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function getMsgCount($status, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $model = $this->newitem();
        $where['msg_to'] = $userid;
        $where['msg_status'] = $status;
        $res = $model->where($where)->count();
        return $res;
    }

    /**
     * 删除用户一条消息
     *
     * @param   null $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function delMsg($no, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $model = $this->newitem();
        $where['msg_to'] = $userid;
        $where['msg_no'] = $no;
        $res = $model->where($where)->delete();
        return $res;
    }
}
