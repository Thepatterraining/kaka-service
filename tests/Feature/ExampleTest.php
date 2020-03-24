<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        
        //            printf("Test Login:\r\n");
        //
        //            printf("Require Token:\r\n");
        //        $response = $this->json('POST', '/api/auth/token/require',array());
        //         $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //
        //            $token = $response->json()["data"]["accessToken"];
        //
        //            printf("$token\r\n");
        //
        //            printf("Prepare Login\r\n");
        //            $user  = "13302076754";
        //            $pwd = "123456";
        //            $response = $this->json('POST', '/api/auth/login',array(
        //                "accessToken"=>$token,
        //                "userid"=>$user,
        //                "pwd"=>$pwd
        //
        //            ));
        //
        //            var_dump($response->json());
        //             $response->assertStatus(200)
        //             ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //            printf("Hello Word\r\n");
        //
        //            $this->assertTrue(true);
    }
}
