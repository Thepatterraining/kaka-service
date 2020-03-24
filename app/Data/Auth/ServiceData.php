<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class ServiceData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\Service';

    protected $no = 'auth_api';

    /**
     * 查询是否有权限访问
     *
     * @param  $url
     * @author zhoutao
     * @date   17.8.10
     */ 
    public function checkAuth($url, $userid)
    {   
        $info = $this->getByNo($url);
        if (empty($info)) {
            //     info('223424323423424324');
            return true;
        }
        
        $auth = DB::select(
            "select count(*) from `sys_auth_service` 
                        where `sys_auth_service`.`auth_api` = '?' and `sys_auth_service`.`deleted_at` is null and `sys_auth_service`.`id` 
                        in ( 
                            select `sys_auth_item`.`auth_api_id` from `sys_auth_item` 
                            where `sys_auth_item`.`deleted_at` is null and `sys_auth_item`.`id` 
                            in (
                                select distinct `sys_auth_authitem`.`auth_id` from `sys_auth_authitem` 
                                where `sys_auth_authitem`.`deleted_at` is null and `sys_auth_authitem`.`group_id` 
                                in (
                                    select `sys_auth_members`.`group_id` from `sys_auth_members` 
                                    where `authuser_id` = '?' and `sys_auth_members`.`deleted_at` is null)))", [$url,$userid]
        );
        if ($auth > 0) {
            return true;
        } else {
            return false;
        }
    }

}
