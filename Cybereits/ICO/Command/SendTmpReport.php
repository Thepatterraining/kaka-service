<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;
use Cybereits\Common\Utils\ExcelMaker;
use Illuminate\Support\Facades\Mail;
use Cybereits\Modules\ICO\Mail\ICOReport;

class SendTmpReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:tmpreport';

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
        $date = Date("y-M-d");
        $com_name = $date."company.xlsx";
        $cus_name = $date."paymentorder.xlsx";
        $order_name = $date."order.xlsx";
        $com_file = "/tmp/".$com_name;
        $cus_file = "/tmp/".$cus_name;
        $order_file = "/tmp/".$order_name;
        $coin_file = "/tmp/".$date."_coin_tosend.xlsx";
        $addr_file = "/tmp/".$date."_wl.xlsx";
       // ExcelMaker:: saveQueryExcel("select ico_companyorder.name as `名称` ,ico_companyorder.amount as `登计` ,coin_sys_address_amount.address_amount `实收`  from ico_companyorder ,coin_sys_address_amount  where payaddress = coin_sys_address_amount.address", $com_file);
        //ExcelMaker:: saveQueryExcel("select ico_order.name as `name`,  concat('\'',ico_order.idno) as idno,ico_order.mobile as `name`,ico_order.email as `email`,ico_order.amount `amount` ,coin_sys_address_amount.address_amount  `address_amount`,ico_order.address,payaddress,ico_order.order_type  from ico_order ,coin_sys_address_amount where  ico_order.payaddress = coin_sys_address_amount.address", $cus_file);
        //jExcelMaker:: saveQueryExcel("select email,name,mobile,amount,order_type,status,scale from ico_order where order_type in (1,2)", $order_file);
        //ExcelMaker:: saveQueryExcel(" select address,scale*accept_amount as coin_2_send,email ,amount,accept_amount,status  from ico_order where order_type in (8) and status in (2,3,4,5,6)", $coin_file);
//        $sql1 = "select name,concat('\'',idno) as idno,mobile,email,address,order_type,status,amount ,payaddress from ico_order where id in (select minid from (select address,count(*) c ,min(id) minid  from ico_order where  order_type = 1  group by address)t1 where c = 1 )";
   //      $sql1 = "select name,concat('\'',idno) as idno,mobile,email,address,order_type,status,amount ,payaddress from ico_order ";
 //    
	   $sql1 = "select name ,address,accept_amount from ico_order where order_type = 10 and status = 2";
	ExcelMaker:: saveQueryExcel($sql1, $addr_file);
      //  $sql2 = "select address,sum(case when address_coin_name='ETH' then address_amount else 0 end) as ETH, sum(case when address_coin_name='CRE' then address_amount else 0 end) as CRE from coin_sys_address_amount group by address";
       // $sql2 = "select t.address,eth,t.cre,(case when ico_order.name is not null then ico_order.name else ico_companyorder.name end ) name,(case when ico_order.order_type is not null then ico_order.order_type else 'company' end ) type  from ( select address,sum(case when address_coin_name='ETH' then address_amount else 0 end) as ETH, sum(case when address_coin_name='CRE' then address_amount else 0 end) as CRE from coin_sys_address_amount group by address) t  left  join ico_companyorder on t.address = ico_companyorder. payaddress left join  ico_order on t.address=ico_order.payaddress or t.address = ico_order.address";
        $sql2 = "select t.address,eth,t.cre,(case when ico_order.name is not null then ico_order.name else ico_companyorder.name end ) name,(case when ico_order.order_type is not null then ico_order.order_type when ico_companyorder.name is not null then  'company' else 'system' end ) type,ifnull(ico_order.email,'') as email ,ifnull(ico_order.mobile,'') as mobile from ( select address,sum(case when address_coin_name='ETH' then address_amount else 0 end) as ETH, sum(case when address_coin_name='CRE' then address_amount else 0 end) as CRE from coin_sys_address_amount group by address) t  left  join ico_companyorder on t.address = ico_companyorder. payaddress left join  ico_order on t.address=ico_order.payaddress or t.address = ico_order.address";
        $coininfo_file = "/tmp/".$date."_address_info.xlsx";
	$trans_recordfile = "/tmp/".$date."_out_log.xlsx";;
	$trans_infile = "/tmp/".$date."_in_log.xlsx";;


        ExcelMaker:: saveQueryExcel($sql2, $coininfo_file);
        $transLog = "select  blockid,txid,`from`,`to`,`coin_type`,amount,gas,gas_price,gas_used from coin_trans_record where `from` in (select address from coin_sys_address_info) order by blockid";
        ExcelMaker:: saveQueryExcel($transLog,$trans_recordfile);
	$insql = "select  blockid,txid,`from`,`to`,`coin_type`,amount,gas,gas_price,gas_used from coin_trans_record where `to` in (select address from coin_sys_address_info) order by blockid";

	ExcelMaker:: saveQueryExcel($insql,$trans_infile);
	$array = [
     "geyunfei@kakamf.com"=>"云飞",
      //  "xuyang@kakamf.com"=>"许老师",
  //      "chendonghao@kakamf.com"=>"浩哥",
   ///1  "haojinyi@kakamf.com"=>"郝爷",
    //"tanbochao@kakamf.com"=>"谭谭",
     // "sunhongshi@kakamf.com"=>"宏拾" ,
///	"gaobo@kakamf.com"=>"GaoBo"
      ];
        foreach ($array as $mail=>$name) {
            Mail::to([$mail])->send(new ICOReport($mail, $name, [$addr_file,
	/**	$com_file,$cus_file,$order_file,$coin_file,
		$trans_recordfile,
		$trans_infile,
		$coininfo_file,*/
		]));
        }
    }
}
