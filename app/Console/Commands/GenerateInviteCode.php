<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Activity\InvitationCodeData ;
use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\InfoData;
use App\Data\Activity\ItemData;
use App\Data\User\UserData;

class GenerateInviteCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:inv';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make inv code';
    
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
        
        $codeFac = new InvitationCodeData();
 


        /*
        $userFac = new UserData();
        
        $result = $userFac->query(["user_invcode"=>["=",""]],200,1);
        foreach($result["items"] as  $user){
            
            
            $user->user_invcode = $codeFac->createCode($user->id,"SA2017050723070423126");
            dump($user->user_name.' '.$user->user_invcode);
            
            $user->save();
        }*/
        
        $code  = $codeFac->createActivityCode("SA2017050723070423126", 0);


        $this->info("邀请码 :{$code}");

 
        
        
        
        /*
        $array = [
        1000=>["",1,0],
        500=>["",1,1],
        200=>["",1,1],
        100=>["",1,1],
        50=>["",2,2],
        20=>["",3,3],
        10=>["",4,4]
        ];
        $activityFac = new InfoData();
        $this->info("Begin to generate the inv code .");
        
        $file_name = __DIR__.'/inv_code.txt';
        $handle = fopen($file_name,"w");
        $codeFac = new InvitationCodeData();
        $voucherFac = new VoucherInfoData();
        $itemFac = new ItemData();
        
        
        
        $activites = [];
        
        
        $this->info("创建活动");
        $limitCount = 2050;
        $activity = $activityFac->addActivityLimitCount("线下推广1000元活动","2017-5-1","2017-10-1",$limitCount);
        $activity2 = $activityFac->addActivityLimitCount("线下推广2000元活动","2017-5-1","2017-10-1",$limitCount);
        $activies = [$activity2,$activity];
        
        foreach($array as $money=>$val){
        
        $val[0]=$voucherFac->addFullOff($money*100,$money,90);
        $this->info("创建${money}元现金券${val[0]}");
        for($actIndex = 0;$actIndex < count($activies);$actIndex ++){
        
        
        $vIndex =$val[$actIndex +1];
        $vI = 0;
        while($vI < $vIndex){
        
        $activityFac ->addVoucher($activies[$actIndex]->activity_no,$val[0]);
        $vI ++;
        }
        }
        }
        
        $this->comment ("开始生成2000元邀请码");
        $i =0;
        while($i<$limitCount){
        $code = $codeFac->createActivityCode($activity2->activity_no);
        fwrite($handle,$code." 2000\r\n");
        
        $i++;
        }
        $this->comment ("开始生成1000元邀请码");
        $i =0;
        while($i<$limitCount){
        $code = $codeFac->createActivityCode($activity->activity_no);
        fwrite($handle,$code." 1000\r\n");
        $i++;
        }
        
        
        
        fclose($handle);
        
        
        
        
        $this->comment("生成完成,文件位于".__DIR__."./inv_code.txt");       /*
        
        $this->info ("创建活动");
        $this->info("增加现金券");
        
        $this->comment("添加邀请码");
        $this->comment("Begin to gernerate the CODE of CARD 1000");
        for($i = 0;$i<1000;$i++){
        $code = $codeFac->createActivityCode("AC001");
        fwrite($handle,$code." 1000\r\n");
        dump($code);
        }
        
        $this->comment("Begin to gernerate the CODE of CARD 2000");
        for($i = 0;$i<1000;$i++){
        $code = $codeFac->createActivityCode("AC001");
        fwrite($handle,$code." 2000\r\n");
        dump($code);
        }
        
        
        
        
        
        fclose($handle);*/
        
        
        //
    }
}
