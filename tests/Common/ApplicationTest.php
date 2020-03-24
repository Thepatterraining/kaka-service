<?php

namespace Tests\Common;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use Cybereits\System\Data\SystemModelData ;
use Cybereits\Resource\Data\ResourceMongoStoreData;
use Cybereits\Application\Data\ReleaseFac;
class ApplicationTest extends TestCase {
  public function testGetVersion()
    {

      $fac = new ReleaseFac();

      $appid = "F3452E02-AE64-A825-8C29-DFE5B2EA9C57";

      $item = $fac->getLastRelease($appid);
      dump($item);
    }


}