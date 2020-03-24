<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\UserTypeData;
use App\Data\Activity\GroupData;
use App\Data\Activity\InfoData;
use App\Data\Activity\GroupItemData;
use App\Data\Sys\ConfigData;

class AddActivityGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:addactivitygroup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add a user a activity group';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //获取默认活动分组
        $userTypeData  = new UserTypeData();
        $session = resolve('App\Http\Utils\Session');
        $session->userid = 0;
        $sysConfigs = $userTypeData->getData($session->userid);
        
        $activityDefultGroupNo = $sysConfigs[UserTypeData::$ACTIVITY_DEFULT_GROUP];

        //查询有没有，没有就创建
        $activityGroupData = new GroupData();
        $activityGroupInfo = $activityGroupData->getByNo($activityDefultGroupNo);
        if (empty($activityGroupInfo)) {
            $name = '默认分组';
            $type = 'AGT01';
            $activityGroupInfo = $activityGroupData->addGroup($name, $type);
            $activityDefultGroupNo = $activityGroupInfo->group_no;
            $sysConfigData = new ConfigData();
            $key = $userTypeData::$ACTIVITY_DEFULT_GROUP;
            $sysConfigData->saveConfig($key, $activityDefultGroupNo);
            // $model = $activityGroupData->newitem();
            // $model->group_no = $activityDefultGroupNo;
            // $model->group_name = $name;
            // $model->group_type = $type;
            // $activityGroupData->create($model);
            // $activityDefultGroupNo = $model->group_no;
        }
        
        //查询所有活动
        $activityData = new InfoData();
        $activityGroupItemData = new GroupItemData();
        $activities = $activityData->getActivities();
        foreach ($activities as $activity) {
            $activityNo = $activity->activity_no;
            //查询活动有没有分组
            $info = $activityGroupItemData->getGroupItem($activityNo);
            if (empty($info)) {
                //把这个活动添加到默认分组
                $activityGroupItemData->add($activityDefultGroupNo, $activityNo);
            }
        }
        $this->alert('执行成功');
    }
}
