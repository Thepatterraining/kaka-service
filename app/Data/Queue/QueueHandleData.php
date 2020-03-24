<?php
namespace App\Data\Queue;

use App\Data\Notify\INotifyData;
use App\Data\Notify\DefineData;
use App\Data\Notify\NotifyDefineData;
use App\Data\Notify\NotifyGroupData;
use App\Data\Notify\NotifyGroupMemberData;
use App\Data\Notify\NotifyLogData;
use App\Data\Notify\EventLogData;
use App\Data\Notify\NotifyUserLogData;
use App\Data\Notify\NotifyGroupSetData;
use App\Data\App\UserInfoData;
use App\Data\Auth\UserData;
use App\Mail\NotifyReport;
use App\Mail\SettlementReport;
use App\Data\User\UserData as UseData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QueueHandleData
{
    /**队列信息操作
     * @param data      object 队列数据
     * @param jobClass  string model类名
     * @param handle    string 监听状态
     * @author liu
     * @version 0.1
     */
    public function handle($data,$jobClass,$handle)
    {
        $defineData=new DefineData();
        $notifyDefineData=new NotifyDefineData();
        $groupData=new NotifyGroupData();
        $notifyGroupMemberData=new NotifyGroupMemberData();
        $setData=new NotifyGroupSetData();
        $userInfoData=new UserInfoData();
        $notifyUserLogData=new NotifyUserLogData();
        $notifyLogData=new NotifyLogData();
        $eventLogData=new EventLogData();
        $userData=new UserData();
        $useData=new UseData();
$checkClass=$jobClass;
        if (!class_exists($checkClass)) {
            return ;
        }
        //找寻监听条目  select * from `event_define` where event_model = `class` and event_key = `handle`;
        $eventInfo=$defineData->getListen($jobClass, $handle);
        //数据判空
        // 如果为空，则证明没有定义

        if (empty($eventInfo)) {
            return ;
        }
        $eventType=$eventInfo->event_type;
        
        //获取通知定义
        //select * from event_notifyydefine where notify_event = id ;
        $notifyInfos=$notifyDefineData->getNotifyInfo($eventInfo->id);
        if ($notifyInfos->isEmpty()) {
            return ;
        }

        // dump("start");
        $users=array();
        $date = date('Y-m-d H:i:s');
        // 偏历 event_notifydefine 中的内容。
        foreach ($notifyInfos as $notifyInfo) {
            //获取通知处理类
            $specialClass=$notifyInfo->notify_specialclass;
            if ($notifyInfo->notify_filter!=null && class_exists($specialClass)) {
                $specialObj=new $specialClass();
                $filter=$notifyInfo->notify_filter;
                //filter中插入的是sql语句
                $search=DB::select($filter, [$data["id"]]);
                if (empty($search)) {
                    continue;
                }
            }
            //添加通知log
            $notifyLogData->addLog($date,$notifyInfo);
            $level=$notifyInfo->notify_level;
            $type=$notifyInfo->notify_type;
            //添加额外参数
            $param=$notifyInfo->notify_param;
            if($param)
            {
                $data['params']=json_decode($param,true);
            }
            else
            {
                $data['params']=null;
            }
            
            $notifyGroup=$setData->getGroup($notifyInfo->id);
            //获取通知相关组
            if (($notifyGroup->isEmpty()) || $eventType==INotifyData::BUGCHECK) {
                if ($eventType==INotifyData::DEFAULT_CHECK || $eventType==INotifyData::BUGCHECK) {
                    if (class_exists($specialClass)) {
                        $specialObj=new $specialClass();
                        $attach=null;
                        //处理类中存在相应方法才会执行

                        if (method_exists($specialObj, 'notifyrun')) {
                            $specialObj->notifyrun($data);
                        }
                        continue;
                    }  
                } else {
                    continue;
                }
            }  
            $this->notifyHandle($notifyGroup, $type, $eventInfo);
        }
    }

    /**消息处理（有分组）
     * @param notifyGroup   object 通知组
     * @param type          string 通知方式
     * @param eventInfo     object 监听状态
     * @author liu
     * @version 0.1
     */
    private function notifyHandle($notifyGroup,$type,$eventInfo)
    {
        $notifyGroupMemberData=new NotifyGroupMemberData();
        $users=$notifyGroupMemberData->getNotifyMembers($notifyGroup);
        if (empty($users)) {
            return false;
        }

        foreach ($users as $user) {
            switch ($type) {
                case INotifyData::EMAIL:
                {                                                                   
                        $address=$user->authuser_email; 
                        $name=$user->authuser_name;
                        $notifyName=$eventInfo->event_name;
                        if ($address) {
                            if (class_exists($specialClass)) {
                                $specialObj=new $specialClass();
                                $attach=$data;
                                if (method_exists($specialObj,'notifyemailrun')) {
                                    $specialObj->notifyemailrun($address,$name,$notifyName,$attach);
                                }
                            }         
                            else if ($eventType==INotifyData::DAILY_CHECK) {
                                Mail::to([$address])->send(new SettlementReport($address, $name, $date, $res, $attach));
                            }
                            else {
                                Mail::to([$address])->send(new NotifyReport($address, $name, $notifyName, null));
                            }
                            $notifyUserLogData->addLog($date, $eventInfo, $eventInfo, $user, $notifyName, $address);
                        }
                    break;
                }
                default:
                    break;
            }
        }
    }
}
