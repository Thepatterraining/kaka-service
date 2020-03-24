<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;

class UserData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\User';

    /**
     * 创建管理员
     *
     * @param   $user model
     * @param   $pwd 密码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function add($user, $pwd, $email)
    {
    
        //
        $this->create($user);
        // $user = $this->get($user);
        $user->auth_pwd = md5("pwd".$user->id.$pwd);
        $res = $this->save($user);
        return $res;
    }

    /**
     * 新建管理员登陆密码
     *
     * @param   $user 管理员
     * @param   $pwd  密码
     * @param   $email  邮件    
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function savePwdAndEmail($user, $pwd,$email)
    {
        $user->auth_pwd = md5("pwd".$user->id.$pwd);
        $user->auth_email = $email;
        $res = $this->save($user);
        return $res;
    }

    /**
     * 修改登陆密码
     * @param   $user 用户model
     * @param   $newPwd 新的登陆密码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePwd($user, $newPwd)
    {
        $user->auth_pwd = md5("pwd".$user->id.$newPwd);
        $this->save($user);
    }

    /**
     * 管理员忘记密码
     * 
     * @param   $phone 管理员
     * @param   $pwd 密码
     * @author  zhoutao
     * @version 0.1
     * @date    2018.3.20
     */
    public function forgetPwd($phone, $pwd)
    {
        $user = $this->getUser($phone);
        $user->auth_pwd = md5("pwd".$user->id.$pwd);
        $res = $this->save($user);
    }

    /**
     * 修改管理员登陆密码
     *
     * @param   $user 管理员
     * @param   $pwd  密码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function saveEmail($user, $email)
    {
        $user->auth_email = $email;
        $res = $this->save($user);
        return $res;
    }

    /**
     * 查询管理员信息
     *
     * @param   $identify 登录名或者手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function getUser($identify)
    {
        $model = $this->newitem();
        $user = $model->where('auth_id', $identify)
            //     ->orWhere('user_email',$identify)
            ->orWhere('auth_mobile', $identify)
            ->orwhere('auth_email', $identify)
            ->first();
        return $user;
    }

    /**
     * 按手机号删除管理员
     *
     * @param   $phone 手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function delUser($phone)
    {
        $model = $this->newitem();
        $res = $model->where('auth_mobile', $phone)->delete();
        return $res;
    }

    /**
     * Check the password
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function checkPwd($user, $pwd)
    {
        return $user->auth_pwd === md5("pwd".$user->id.$pwd);
    }

    public function getUserMenus($userid)
    {   
        $auths = DB::select("select  DISTINCT `sys_auth_item`.`id`,`sys_auth_item`.`auth_no`, `sys_auth_item`.`auth_name`, `sys_auth_item`.`auth_url`, `sys_auth_item`.`auth_type`, `sys_auth_item`.`auth_notes` from`auth_user` inner join `sys_auth_members` on `auth_user`.`id` = `sys_auth_members`.`authuser_id`inner join `sys_auth_group` on `sys_auth_members`.`group_id` = `sys_auth_group`.`id` inner join `sys_auth_authitem` on `sys_auth_group`.`id` = `sys_auth_authitem`.`group_id` inner join `sys_auth_item` on `sys_auth_authitem`.`auth_id` = `sys_auth_item`.`id` where `auth_user`.`id` = ? and `sys_auth_item`.`auth_type` = ? and `sys_auth_authitem`.`deleted_at` is null and `sys_auth_item`.`deleted_at` is null and `sys_auth_members`.`deleted_at` is null and `sys_auth_group`.`deleted_at` is null order by `sys_auth_item`.`auth_no`", [$userid,ItemData::MENU_TYPE]);
        return $auths;
    }
}
