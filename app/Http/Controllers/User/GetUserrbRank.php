<?php

namespace App\Http\Controllers\User;

use App\Http\Adapter\Sys\NotifyAdapter;
use App\Data\Sys\NotifyData;
use Illuminate\Http\Request;
use App\Data\App\UserInfoData;
use App\Data\Sys\UserData;
use App\Data\User\UserRebateRankdayData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Controllers\Controller;


class GetUserrbRank extends Controller
{
    public function run()
    {
        $request=$this->request->all();
        //$appId=$request->appid;
        $userInfoData=new UserInfoData();
        $userData=new UserData();
        $res=array();
        $userRebateRankdayData=new UserRebateRankdayData();
        $reportUserrbSubDayData=new ReportUserrbSubDayData();
        $end=date("Y-m-d");
        $date=date_create($end);
        $lastDate=date_create($end);
        $endDate=date_create($end);
        $appId="wx27afbba3da06ad42";

        date_add($date, date_interval_create_from_date_string("-1 days"));
        date_add($lastDate, date_interval_create_from_date_string("-2 days"));
        $existDate=date_format($date, "Y-m-d");
        //dump($lastDate);
        
        // dump($existDate);
        //$date=date_format($date,'Y-m-d');
        // dump($date);
        //$lastDate=date_format($lastDate,'Y-m-d');

        // $info=$userRebateRankdayData->getAllRank(date_format($date,"Y-m-d"));
        // //第一次取不到排行，生成排行再取一次
        // if((empty($info))||(count($info)!=20))
        // {
        //     $userRebateRankdayData->saveRank(date_format($date,"Y-m-d"));
        //     $info=$userRebateRankdayData->getAllRank(date_format($date,"Y-m-d"));
        // }
        // //第二次取不到排行，取最新排行
        // while((empty($info))||(count($info)!=20))
        // {
        //     $info=$userRebateRankdayData->getAllRank(date_format($lastDate,"Y-m-d"));
        //     date_add($lastDate, date_interval_create_from_date_string("-1 days"));
        // } 
        $idCount=$userData->getMaxIdDay($endDate);
        $info=$reportUserrbSubDayData->getTop(date_format($endDate, "Y-m-d"), $idCount);
        // 若取不到日报排行，则取日报最新排行
        while((empty($info)))
        {
            date_add($endDate, date_interval_create_from_date_string("-1 days"));
            $idCount=$userData->getMaxIdDay($endDate);
            $info=$reportUserrbSubDayData->getTop(date_format($date, "Y-m-d"), $idCount);
            date_add($date, date_interval_create_from_date_string("-1 days"));
        } 
        // dump($date);
        $tmpDate=$date;
        date_add($tmpDate, date_interval_create_from_date_string("1 days"));
        // dump($existDate);
        if($existDate!=$tmpDate) {
            $end=$tmpDate;
        }

        for($i=1;$i<=20;$i++)
        {
            $item = [];
            $item['rank'] = $i;
            // $info=$userRebateRankdayData->getRank(date_format($date,"Y-m-d"),$i);
            $info=$reportUserrbSubDayData->getTop($end, $i);  
            // $userId=$info->rank_user;
            $userId=$info->report_user;
            $userInfo=$userInfoData->getByUserid($userId, $appId);
            /*while(empty($userInfo))
            {
                $m++;
                $userInfo=$userInfoData->getByUserid($m);
            }*/
            //若能取到微信用户信息，则获取其微信头像和昵称
            if(!empty($userInfo)) {
                $item['headImage']=$userInfo->headimgurl;
                $item['nickName']=$userInfo->nickname;  
                $user=$userData->getUser($userId); 
                if($item['headImage']==null) {
                    $item['headImage']="https://www.kakamf.com".$user->user_headimgurl;
                } 
                if($item['headImage']==null) {
                    $item['headImage']="https://www.kakamf.com/upload/touxiang/tianping.jpg"; //放置默认头像，目前暂为天平座
                }            
                if($item['nickName']==null) {
                    $name=$user->user_name;
                    if($name==null) {
                        $mobile=$user->user_mobile;
                        $name='****'.mb_substr($mobile, 7, 10, 'utf-8');
                    }
                    else
                    {
                        $name=mb_substr($name, 0, 1, 'utf-8').'**';
                    }
                    $item['nickName']=$name;
                }
            }
            //若获取不到微信信息，则获取其用户头像和名称
            else{
                $user=$userData->getUser($userId);
                $item['headImage']="https://www.kakamf.com".$user->user_headimgurl;
                if($item['headImage']==null) {
                    $item['headImage']="https://www.kakamf.com/upload/touxiang/tianping.jpg";
                } 
                $name=$user->user_name;
                if($name==null) {
                    $mobile=$user->user_mobile;
                    $name='****'.mb_substr($mobile, 7, 10, 'utf-8');
                }
                else
                {
                    $name=mb_substr($name, 0, 1, 'utf-8').'**';
                }
                $item['nickName']=$name;
            }

            $item['money']=$info->report_rbbuy_result;
            $res[]=$item;
            
        }
        
        return $this->Success($res);
    }

}