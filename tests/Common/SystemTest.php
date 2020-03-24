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
class SystemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetModels()
    {

      $datafac = new SystemModelData();
      $item = $datafac  -> GetList();
      dump($item);
    }

    public function testMongo(){

      $fac = new ResourceMongoStoreData();

      $item = $fac -> NewItem();
      $item->data = "dfasass a";
      $fac->Create($item);
      $id = "5a94e9b3421aa918e47238c2";
      $save = $fac->Get($id);
      if ($save!=null) {
          dump($save->data);
      }
      $filename= "/Users/geyf/Documents/成图/三里屯 20171029/3E9A11032.jpg";
      $fac->StoreFile($filename);
    }
}