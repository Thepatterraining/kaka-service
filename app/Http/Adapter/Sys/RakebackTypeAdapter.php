<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class RakebackTypeAdapter extends IAdapter
{
    protected $mapArray = [

    "name"=>"user_rbtype_name"
    ,"enable"=>"user_rbtype_enable"
    ,"rechargerate"=>"user_rbtype_rechargerate"
    ,"buyrate"=>"user_rbtype_buyrate"
    ,"lrecharge"=>"user_rbtype_lrecharge"
    ,"trecharge"=>"user_rbtype_trecharge"
    ,"lbuy"=>"user_rbtype_lbuy"
    ,"tbuy"=>"user_rbtype_tbuy"
    ,"index"=>"user_rbtype_index"
    ];

    protected $dicArray = [
       
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
