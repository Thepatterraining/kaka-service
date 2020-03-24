<?php

namespace Cybereits\Modules\COIN\Command;

use Illuminate\Console\Command;
use Cybereits\Modules\COIN\Data\InternalTransData ;

class CreateTransDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eth:intertrans {address} {type} {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系统内部钱包转帐 address-转出地址 type-token类型  amount-数量';

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

		$from = $this->argument("address");
		$coin = $this->argument("type");
		$amount = $this->argument("amount");
		$to = "";


		$trans_data = new InternalTransData();
		
		$doc = $trans_data -> CreateDoc($from,$to,$coin,$amount);

	   $trans_data -> Check($doc->id);
		$this->info("internal doc from {$from} to xx trans {$coin}-{$amount} created . ");
	

		
	    
	}
} 
