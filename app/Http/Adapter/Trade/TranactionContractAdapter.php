<?php
namespace App\Http\Adapter\Trade;

use App\Http\Adapter\IAdapter;

class TranactionContractAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"contract_no"
    ,"orderNo"=>"transaction_orderno"
    ,"firstNo"=>"first_no"
    ,"firstName"=>"first_name"
    ,"firstAgent"=>"first_agent"
    ,"fristSign"=>"frist_sign"
    ,"secondNo"=>"second_no"
    ,"secondName"=>"second_name"
    ,"secondAgent"=>"second_agent"
    ,"secondSign"=>"second_sign"
    ,"thirdNo"=>"third_no"
    ,"thirdName"=>"third_name"
    ,"thirdAgent"=>"third_agent"
    ,"thirdSign"=>"third_sign"
    ,"fourthNo"=>"fourth_no"
    ,"fourthName"=>"fourth_name"
    ,"fourthAgent"=>"fourth_agent"
    ,"fourthSign"=>"fourth_sign"
    ,"contractDate"=>"contract_date"
    ,"contractRate"=>"contract_rate"
    ,"contractCount"=>"contract_count"
    ,"contractAmount"=>"contract_amount"
    ];
    protected $dicArray =[
    
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
