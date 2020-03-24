<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Activity\InvitationCodeData;
use App\Data\User\UserData;

class invCodeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $codeFac = new InvitationCodeData();
        $userFac = new UserData();
        $j = 200;
        while ($j<300) {
            //		dump ($codeFac->createCode(1));
               $user = $userFac->newItem();
              $user->user_mobile = "18612312".$j;

               $userFac->registUserWithActivity($user, "123456", "66fy7n");
              $j++;
        }
        $this->assertTrue(true);
    }
}
