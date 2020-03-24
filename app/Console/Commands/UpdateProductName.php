<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Product\InfoData;

class UpdateProductName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:updateProductName';

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
     * 更新产品名称
     *
     * @author zhoutao
     * @date   2017.9.13
     *
     * @return mixed
     */
    public function handle()
    {
        $productData = new InfoData;
        $productModel = $productData->newitem();
        $products2 = $productModel->get();
        foreach ($products2  as $product2) {
            $this->info('修改前'.$product2->product_name);
            if (strpos($product2->product_name, '德胜房产系列002号') === 0) {
                $product2->product_name = str_replace('德胜房产系列002号', '西城房产收益权002号', $product2->product_name);
            } else if (strpos($product2->product_name, '德胜房产系列001号') === 0) {
                $product2->product_name = str_replace('德胜房产系列001号', '西城房产收益权001号', $product2->product_name);
            } else if (strpos($product2->product_name, '朝阳房产系列001号') === 0) {
                $product2->product_name = str_replace('朝阳房产系列001号', '朝阳房产收益权003号', $product2->product_name);
            } else if (strpos($product2->product_name, '西城房产收益权系列004号') === 0) {
                $product2->product_name = str_replace('西城房产收益权系列004号', '西城房产收益权004号', $product2->product_name);
            }
            $this->info('修改后'.$product2->product_name);
            $product2->save();
        }
        $this->info('ok');
    }
}
