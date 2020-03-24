<?php

namespace Tests\Unit\ThirdRecharge;
use Tests\TestCase;
use App\Data\Cash\UserRechargeData;

class RechargeTest extends  TestCase
{



    public function testRechargeAndConfirm()
    {

        $this->init();

        




         
    }

    public function testRechargeAndRefuse()
    {

        $this->init();


    }
    
    private  function init()
    {

        $rechargeData = new UserRechargeData;

        $ch_id = 5;



    }



}