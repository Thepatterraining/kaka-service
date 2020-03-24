<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;
use Illuminate\Support\Facades\DB;
use Cybereits\Modules\ICO\Data\WaletData;
class Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:report';

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
        
      $waletData = new WaletData();
      $send = new SendCloud();
      $total = $waletData->GetTotal();
      $emails = [
        "geyunfei@kakamf.com",
        "xuyang@kakamf.com",
        "haojinyi@kakamf.com",
        "tanbochao@kakamf.com",
        "chendonghao@kakamf.com"
      ];
      foreach($emails as $mail){
        $send->SendReport($mail,$total);
      }
       
    }
}
