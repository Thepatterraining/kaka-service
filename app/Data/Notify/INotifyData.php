<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
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
use App\Mail\CoinErrorReport;
use App\Mail\CashErrorReport;
use App\Mail\DBErrorReport;
use App\Data\User\UserData as UseData;
use Illuminate\Support\Facades\Mail;
// use App\Mail\NotifyReport;

class INotifyData
{
    const EMAIL='NT01';
    const MESSAGE='NT02';
    const WECHAT='NT03';
    const DAILY_CHECK='NY01';
    const COINERRORCHECK='NY05';
    const CASHERRORCHECK='NY06';
    const BUGCHECK='NY07';
    const DEFAULT_CHECK='NY00';
    const SURVEY_CHECK='NY08';

    public function doJob($event,$res=null,$attach=null,$start)
    {
        //传入事件id，后续可能会传类，再进行更改
        //$event=$this->request->input('event');
        //  $event=1;

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
        if(!is_object($start))
        {   
          $start=date_create($start);
        }   
        $date=date_format($start,"Y-m-d");
        $address=null;

        $eventInfo=$defineData->getEventInfoByType($event);
        $eventLogData->addLog($date,$eventInfo);
        // dump($eventInfo);
        if(!empty($eventInfo))
        {
            $notifyInfo=$notifyDefineData->getNotifyInfo($eventInfo->id);
            // dump($notifyInfo);
            if(!$notifyInfo->isEmpty())
            {
                foreach($notifyInfo as $info)
                {
                    // var_dump($info);
                    $notifyLogData->addLog($date,$info);
                    $level=$info->notify_level;
                    $type=$info->notify_type;
                    $notifyGroup=$setData->getGroup($info->id);
                    // dump($notifyGroup);
                    if(!$notifyGroup->isEmpty())
                    {
                        $users=$notifyGroupMemberData->getNotifyMembers($notifyGroup);
                        // dump($users);
                        if(!empty($users))
                        {
                            foreach($users as $user)
                            {           
                                //dump($user);
                                //编写内容
                                //$text=createText($info->notify_fmt,$level);         
                                switch($type)
                                {
                                    case INotifyData::EMAIL:
                                    {         
                                        $address=$user->authuser_email; 
                                        // dump($address);
                                        $name=$user->authuser_name;
                                        //dump($eventInfo);
                                        $notifyName=$eventInfo->event_name;
                                        if($address)
                                        {
                                            if($event==INotifyData::DAILY_CHECK)
                                            {
                                                if ($address != 'haojinyi@kakamf.com') {
                                                    Mail::to([$address])->send(new SettlementReport($address,$name,$date,$res,$attach));
                                                }
                                                
                                                // dump($address);
                                            }
                                            else if($event==INotifyData::COINERRORCHECK)
                                            {
                                                Mail::to([$address])->send(new CoinErrorReport($date,$res));
                                            }
                                            else if($event==INotifyData::CASHERRORCHECK)
                                            {
                                                Mail::to([$address])->send(new CashErrorReport($date,$res));
                                            }
                                            else if($event==INotifyData::BUGCHECK)
                                            {
                                                Mail::to([$address])->send(new DBErrorReport($res));
                                            }
                                            else
                                            {
                                                Mail::to([$address])->send(new NotifyReport($address,$name,$notifyName,null));
                                            }
                                            $notifyUserLogData->addLog($date,$info,$eventInfo,$user,$notifyName,$address);
                                        }

                                        break;
                                    }
                                    case INotifyData::MESSAGE:
                                    {
                                        $address=$user->authuser_mobile;
                                        if(!$address)
                                        {// message($text);
                                        // $notifyUserLogData->addLog($date,$info,$eventInfo,$user,$text,$address);
                                        }
                                        break;
                                    }
                                    case INotifyData::WECHAT:
                                    {
                                        // $user=$useData->getUser($user->auth_mobile);
                                        // $wechatUser=$infoData->getByUserId($user->id,"wx27afbba3da06ad42");
                                        $address=$user->authuser_openid;
                                        if(!$address)
                                        // {
                                            // wechat($text);
                                            // $notifyUserLogData->addLog($date,$info,$eventInfo,$user,$text,$address);
                                        // }
                                        break;
                                    }
                                    default:
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
}