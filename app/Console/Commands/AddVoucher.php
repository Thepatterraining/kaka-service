<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Data\Trade\TranactionOrderData;
use App\Data\User\UserData;
use App\Data\Activity\VoucherStorageData;
use App\Data\App\UserInfoData;
use App\Data\Activity\RegVoucherData;

class AddVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:voucher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $transData  = new TranactionOrderData();
 


        $queryFilter = [
            "order_sell_userid"=>['=',7]
        ];

        $transData -> queryAllWithoutPageturn(
            $queryFilter,
            function ($item,$index) {
                $storageFac = new VoucherStorageData();
                $userID = $item->order_buy_userid;
                $ammount =$item->order_amount;
                $wxFac = new UserInfoData();
                $appId = "wx27afbba3da06ad42";
                $voucherQuery = [
                    "voucherstorage_jobno"=>['=',$item->order_no]
                ];
                $vitem = $storageFac -> getFirst($voucherQuery);
                $userData= new UserData();
                if($vitem===null) {
                                        
                    
                    

                    $user =$userData->getUser($userID);
                    if($user!=null) {
                                            
                    
                        $session = resolve('App\Http\Utils\Session');
                        $session->userid = $userID;
                        $wechatUser = $wxFac->getUserInfo($userID, $appId);
                        $voucherFac = new RegVoucherData();
                        $amount = round($item->order_amount, 2);
                        $str = $item->order_no." 未用券 ".$amount." ".$user->user_name." ".$user->user_mobile;
                     
                       
                        $voucher = $voucherFac->getVoucher($amount);
                        if($voucher!=null) {
                            $str = $str." ".$voucher->vaucher_name;
                        }
                        if($wechatUser!=null) {
                               $str = $str." ".$wechatUser->nickname;
                        }       
                            
                            $this->info($str);
                                    

                    }else{
                        $this->info($item->order_no."未用券");
                    }
                }else{
                    // $this->info($item->order_no."用券".$vitem->vaucherstorage_no);
                }
                //dump($item->order_no);
            }
        );



        //
        // 1.得到所有交易列表
        // 2.针对每一个交易查看是否有可用券
        // 3.如果可用,列出用户和微信

    }
}
