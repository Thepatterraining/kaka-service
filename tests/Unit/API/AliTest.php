<?php
namespace Tests\Unit\API;
use App\Data\API\AliAPI\API;
 
use Tests\TestCase;

class AliTest extends TestCase
{

    
    public function testAccessTokenTests()
    {

 

        dump(API::QueryMobileInfo("18612312326"));
        dump(API::QueryIDInfo("231124198405022117"));
        dump(API::QueryIpInfo("119.61.27.78"));
        
        
    }
}