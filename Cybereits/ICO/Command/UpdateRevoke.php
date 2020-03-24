<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;
use Cybereits\Modules\ETH\API\EtherScanApi;
class UpdateRevoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:revoke_check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查用户退币情况';

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
       

        $api = new EtherScanApi();

        $from = "0xe85aD77c0d3657FDda3Ca74ED6f499C3f21b83d0";
        $to = "0xf3B940852A6ca5E5308aAF9130C27FB65EdE6Bff";
        $res = $api->QueryAddTrans($to);
       // dump($res);

        foreach($res as $item){
         
            
        }
        $sys_add = "0xf3B940852A6ca5E5308aAF9130C27FB65EdE6Bff";
        $data = $api->QueryToken($sys_add);
        dump($data);


        /**
         * 先查询用户是否打币进来
         * 如果有，则更新相应的钱包地址
         * 更新状态
         */
        $order_data = new OrderData();
        $filter = [
            "status"=> 6
        ];

        $items = $order_data->Query($filter);

        foreach($items as $item){
            $data = $api->QueryToken($sys_add);
            if($data != -1){

            }
        }


        /**
         * 查询发出的交易是否成功
         * 如果有, 则更新相应的钱包
         * 更新订单状态
         */
        /*
        $order = new OrderData();
        $add = "0xe85aD77c0d3657FDda3Ca74ED6f499C3f21b83d0";
        $order->AcceptRevoke($add);*/


     
    }
}
