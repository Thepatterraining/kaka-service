<?php
//
//namespace Tests\Feature;
//
//use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//use App\Data\Auth\AccessToken;
//use App\Data\Utils\DocNoMaker;
//
//class BaseTest extends TestCase
//{
//
//    public $token;
//    public function setUp()
//    {
//
//    }
//    /**
//     * A basic test example.
//     *
//     * @return void
//     * @covers
//     */
//    public function testExample()
//    {
//
////        $value = '424532';
////        $value = preg_replace('/([\x80-\xff]*)/i','',$value);
////        if (preg_match('/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)$/',$value)) {
////           dd(1);
////        }
////        dd(2);
////        $status[] = 12;
////        dump($status);
////        die;
//
//        $pageIndex = 5;
////        $pageSize = 10;
////        $count = 14;
////
////
////        for($i =2;$i<8;$i++){
////
////            //$count = 45+$i;]\
////            $pageIndex= $i ;
////            $page =  ($pageIndex  - ($count - $count % $pageSize) / $pageSize)  -1;
////            dump('page is '.$page);
////            if(
////                $page==0
////            )
////                    $res =0;
////            else
////
////            $res =$page * $pageSize - ($count % $pageSize === 0  ?
////                        0:($count % $pageSize)) ;
////            //}
////
////            dump($pageIndex . ' offset is '.$res);
////
////        }
////
////        $pageIndex = 6;
////        $res = ($pageIndex - ($count - $count % $pageSize) / $pageSize - 1) * $pageSize + $count % $pageSize;
////        dump($res);die;
//
//
//        dump('测试开始');
//        dump("Require Token:");
//        $response = $this->json('POST', '/api/auth/token/require',array());
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        $token = $response->json()["data"]["accessToken"];
//        $paypwd = '1234qwe';
//        dump($token);
//
////        $this->getUser($token);
//
//        //注册
////        $this->reg($token);die;
//
//        //登陆
//        $user = '13263463442';
//        $userid = $this->login($user,$token);
//
//
//        //发送验证码
////        $phone = '13263463442';
////            $type = 'SLT02';
////            $response = $this->json('POST', '/api/sms/sendcode',array(
////                "accessToken"=>$token,
////                "phone"=>$phone,
////                "type"=>$type,
////            ));
////            $response
////                ->assertStatus(200)
////                ->assertJson([
////                    'code' => 0,
////                ]);
////            dump($response->json()['data']);die;
//
////        $pwd = '123456';
////        $userid = $this->authLogin($token,$user,$pwd);
////        dump($userid);
////
////        $pwd = $this->saveAuthPwd($token,$pwd,'1234qwe');
////        dd($pwd);
//
//        $coinType = 'KKC-BJ0001';
//        $sellNo = 'TS2017040521212388150';
//        $sellOrderList = $this->getsellorder($token,$coinType,$sellNo);
//        dump($sellOrderList);
//
//        //查询消息列表
//        $messageList = $this->getMessage($token);
//        dump('用户消息列表');
//        dump($messageList);
//
//        //查询充值信息
//        $userRecharge = $this->getRechargeList($token);
//        dump($userRecharge);
//
//        //
////        $rechargeInfo = $this->getRechargeInfo($token);
////        dump($rechargeInfo);
//
//        //管理员登陆
////        $pwd = 123456;
////        $userid = $this->authLogin($token,$user,$pwd);
////        dump($userid);
//
//        //修改手机号
////        $this->saveUserPwd($token);
//
//        //创建管理员
////        $data['loginid'] = 'emo';
////        $data['nickname'] = 'emo';
////        $data['mobile'] = 13263463442;
////        $data['name'] = '周涛';
////        $data['idno'] = '421126199803263816';
////        $addAuthUser = $this->addAuthUser($token,$data,123456);
////        dump($addAuthUser);die;
//
//        //查看活动事件
////        dump('活动事件：');
////        $activityFilters = $this->getActivityFilters($token);
////        dump($activityFilters);
//
////        dump('添加活动：');
////        $filters = $activityFilters['data']['0']['no'];
////        $activityFilters = $this->addActivity($token);
////        dump($activityFilters);
//
//        //撤销买单
////        dump('撤销买单');
////        $response = $this->json('POST', '/api/trade/revoketranssell',[
////            "accessToken"=>$token,
////            "transactionSellNo"=>'TS2017040422182667286',
////        ]);
////        dump($response->json());die;
////        $response
////            ->assertStatus(200)
////            ->assertJson([
////                'code' => 0,
////            ]);
////        dump('撤销成功');
////        dump($response->json()['data']);
//
//        $coin_type = 'KKC-BJ0001';
//        //查询项目信息
//        dump('查询项目信息');
//        $itemInfo = $this->getItemInfo($token,$coin_type);
//        dump($itemInfo);
//
//        //查询项目房产信息
//        dump('查询项目房产信息');
//        $houseInfo = $this->getHouseInfo($token,$coin_type);
//        dump($houseInfo);
//
//        //查询同小区交易记录
//        dump('同小区交易记录');
//        $invetInfo = $this->getOrderInfo($token,$coin_type);
//        dump($invetInfo);
//
//        //查询投资分析
//        dump('投资分析');
//        $invetInfo = $this->getInvetInfo($token,$coin_type);
//        dump($invetInfo);
//
//        //查询分租日期
//        dump('分租日期');
//        $invetInfo = $this->getItemSub($token,$coin_type);
//        dump($invetInfo);
//
//        //查询分租日期
//        dump('热销资产');
//        $invetInfo = $this->getHeatItem($token);
//        dump($invetInfo);
//
//        //查询分租日期
//        dump('证照公式');
//        $invetInfo = $this->getFormula($token,$coin_type);
//        dump($invetInfo);
//
//        //查询卖单列表
//        dump("卖单列表：");
//        $sellList = $this->gettranactionsell($token);
//        dump($sellList);die;
//
//        //查询交易记录
//        dump('代币交易记录：');
//        $userOrderList = $this->getUserOrder($token);
//        dump($userOrderList);
//
//        //现金交易记录
//        dump('现金交易记录');
//        $userCashOrder = $this->getUserCashOrder($token);
//        dump($userCashOrder);
//
//        //现金交易记录
//        dump('首页公告');
//        $userCashOrder = $this->getHomeNews($token);
//        dump($userCashOrder);
//
//        //查询系统银行
//        dump('系统银行：');
//        $sysBank = $this->getSysBank($token);
//        $bankIndex = rand(0,6);
//        $sysBankType = $sysBank['data'][$bankIndex]['no'];
//        dump($sysBankType);
//
//        //查询系统银行卡
//        $sysBankNo = $this->getSysBankNo($token);
//        dump($sysBankNo);
//
//        //查询用户银行卡
//        $bankid = $this->getUserBank($token);
//        dump('用户银行卡');
//        if ($bankid['data'] == null) {
//            dump('绑定银行卡');
//            //绑定银行卡
//            $bankNo = $this->addUserBank($token,$sysBankType);
//        } else {
//            $bankNo = $bankid['data'][0]['no'];
//        }
//
//        //查询用户现金余额
//        $userAccount = $this->getUserAccount($token);
//        dump($userAccount);
//
//        //充值
//        $amount = rand(10000,99999);
//        dump('充值金额：'.$amount);
//        $rachargeNo = $this->racharge($token,$bankNo,$sysBankNo,'13263463442',$amount);
//        dump($rachargeNo);
//        //审核充值
//        if (rand(0,10) > 5) {
//            $confirm = true;
//        } else {
//            $confirm = false;
//        }
////        $rachargeRes = $this->rachargeConfirm($token,$rachargeNo,$confirm);
////        dump($rachargeRes);
//
//        //查询用户现金余额
//        $userAccount = $this->getUserAccount($token);
//        dump($userAccount);
//
//        //提现
////        dump('开始提现');
////        $amount = rand(1000,9999);
////        dump('提现金额：'.$amount);
////        $withRes = $this->with($token,$bankNo,$amount,$paypwd);
////        //提现单据号
////        $withNo = $withRes['data'];
////        dump($withNo);
//        //审核提现
//        dump('审核提现');
//        if (rand(0,10) > 5) {
//            $confirm = true;
//        } else {
//            $confirm = false;
//        }
//        if (rand(0,1)) {
//            $desBankid = $sysBankNo;
//        } else {
//            $desBankid = '';
//        }
////        $withConfirmRes = $this->withConfirm($token,$confirm,$desBankid,$withNo);
////        dump($withConfirmRes);
//
//        //查询用户现金余额
//        $userAccount = $this->getUserAccount($token);
//        dump($userAccount);
//
//        //查询用户代币余额
//        $coinTypeIndex = rand(0,3);
//        $coinType = ['KKC-BJ0001'];
//        $coin_type = $coinType[0];
//        $userCoinList = $this->getUserCoinAccount($token,10,1);
//        dump($userCoinList);
//
//        //充值代币
////        $amount = rand(1000,9999);
////        dump('充值代币数量 ：'.$amount);
////        dump('充值代币：'.$coin_type);
////        dump('充值代币用户ID：'.$userid);
////        if (rand(0,1)) {
////            $rachargeCoinRes = $this->rachargeCoin($token,$amount,$coin_type,$userid);
////        } else {
////            $rachargeCoinRes = $this->rachargeCoin1($token,$amount,$coin_type,$userid);
////        }
////        $rachargeCoinNo= $rachargeCoinRes['data'];
////        dump('充值代币单据号：'.$rachargeCoinNo);
//
//        //审核代币充值
//        if (rand(0,10) > 5) {
//            $confirm = true;
//        } else {
//            $confirm = false;
//        }
////        $CoinRechargeconfirm = $this->rachargeCoinConfirm($token,$rachargeCoinNo,$confirm);
////        dump($CoinRechargeconfirm);
//
//        //查询代币余额
//        $userCoinList = $this->getUserCoinAccount($token,10,1);
//        dump($userCoinList);
//
//        if ($confirm == true) {
//            //代币提现
//            $amount = rand(100,999);
//            dump('提现代币数量:'.$amount);
//            $address = 'sakfjekjfakjkj';
//            $withCoinRes = $this->withCoin($token,$amount,$coin_type,$userid,$address,$paypwd);
//            $withCoinNo = $withCoinRes['data'];
//            dump('提现代币单据号'.$withCoinNo);
//
//            //代币提现审核
//            if (rand(0,10) > 5) {
//                $confirm = true;
//            } else {
//                $confirm = false;
//            }
////            $withCoinConfirmRes = $this->withCoinConfirm($token,$withCoinNo,$confirm);
////            dump($withCoinConfirmRes);
//
//            //查询代币余额
//            $userCoinList = $this->getUserCoinAccount($token,10,1);
//            dump($userCoinList);
//        }
//
//
//
//        //卖出
//        dump('开始卖币：');
//        $count = rand(10,99);
//        $price = rand(1000,5999);
//        $sellNo = $this->tranactionsell($token,$count,$price,$coin_type,$paypwd);
//        dump("卖单号码：".$sellNo['data']['no']);
//        //买入
//        //查询代金券
//        $voucherList = $this->voucher($token,$coin_type,$sellNo['data']['no']);
//        dump('代金券列表：');
//        dump($voucherList);
//
//        //使用代金券
//        if (count($voucherList['data']['voucher']) >= 1) {
//            $voucherNo = $voucherList['data']['voucher'][rand(0,count($voucherList['data']['voucher'])-1)]['vaucher_no'];
//        } else {
//            $voucherNo = null;
//        }
//        dump('代金券号码：'.$voucherNo);
//        dump('开始买币：');
//        $buySellNo = $sellList['data']['items'][rand(0,count($sellList['data']['items'])-1)]['no'];
//        $buyNo = $this->tranactionbuy($token,10,$buySellNo,$voucherNo,$paypwd);
//        dump($buyNo);
//
//
//        //查询公告类型
//        $newsType = $this->getNewType($token);
//        $newsType = $newsType['data'][0]['no'];
//        dump('公告类型：'.$newsType);
//
//        //查询公告推送类型
//        $newsPushType = $this->getNewPushType($token);
//        $newsPushType = $newsPushType['data'][0]['no'];
//        dump('公告推送类型'.$newsPushType);
//
//        //添加公告
////        $data['title'] = '标题';
////        $data['subtitle'] = '副标题';
////        $data['writer'] = '发布人';
////        $data['source'] = '来源';
////        $data['content'] = '内容';
////        $data['type'] = $newsType;
////        $data['pushtype'] = $newsPushType;
////        $data['refurl'] = 'url';
////        $addNewRes = $this->addNews($token,$data);
////        dump($addNewRes);
//
//        //查询公告
//        $sysNewsList = $this->getNews($token);
//        dump('系统公告');
//        dump($sysNewsList);
//
//
////        $this->select($token);
//
////        $this->userSell($token);
//
//        //用户代金券
////        $this->userGetstorage($token);
//
//        $this->assertTrue(true);
//
//    }
//
//    protected function getsellorder($token,$coinType,$sellNo)
//    {
//        $response = $this->json('POST', '/api/user/getcashcoinvoucher',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//            "sellNo"=>$sellNo
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function saveAuthPwd($token,$pwd,$newPwd)
//    {
//        $response = $this->json('POST', '/api/admin/savepwd',array(
//            "accessToken"=>$token,
//            "pwd"=>$pwd,
//            "newPwd"=>$newPwd
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getRechargeInfo($token)
//    {
//        $response = $this->json('POST', '/api/user/getrecharge',array(
//            "accessToken"=>$token,
//            "no"=>"CR2017040523004864652"
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//
//    protected function getRechargeList($token)
//    {
//        $response = $this->json('POST', '/api/user/getrechargelist',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>10,
//            "filters"=>['status'=>['CR00','CR02']]
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function authLogin($token,$user,$pwd)
//    {
//        $response = $this->json('POST', '/api/admin/login',array(
//            "accessToken"=>$token,
//            "userid"=>$user,
//            "pwd"=>$pwd
//
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//
//    }
//
//    protected function addAuthUser($token,$data,$pwd)
//    {
//        $data['data'] = $data;
//        $response = $this->json('POST','/api/admin/adduser',array(
//            "accessToken"=>$token,
//            "data"=>$data,
//            "pwd"=>$pwd
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getHomeNews($token)
//    {
//        $response = $this->json('POST','/api/user/gethomenews',array(
//            "accessToken"=>$token,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getUserCashOrder($token)
//    {
//        $response = $this->json('POST', '/api/user/getuserorder',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>10
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function saveUserPwd($token)
//    {
//        $response = $this->json('POST', '/api/auth/saveuserpwd',array(
//            "accessToken"=>$token,
//            "pwd"=>123456,
//            "newPwd"=>"123456a.A/",
//        ));
//        dump($response->json());die;
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('修改支付密码成功:');
//
//    }
//
//    protected function addActivity($token,$voucherNo,$itemType)
//    {
//        $response = $this->json('POST','/api/admin/addactivi',array(
//            "accessToken"=>$token,
//            "data"=>$data,
//            "voucherNo"=>$voucherNo,
//            "item_type"=>$itemType
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getActivityFilters($token)
//    {
//        $response = $this->json('POST','/api/admin/getacticityfilters',array(
//            "accessToken"=>$token,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getFormula($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/getfromula',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getHeatItem($token)
//    {
//        $response = $this->json('POST','/api/item/getheatitem',array(
//            "accessToken"=>$token,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getItemSub($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/getitemsub',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getOrderInfo($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/getitemorder',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getInvetInfo($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/getinvestinfo',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getHouseInfo($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/gethouseinfo',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getItemInfo($token,$coinType)
//    {
//        $response = $this->json('POST','/api/item/getinfo',array(
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function tranactionbuy($token,$count,$no,$voucherNo,$paypwd)
//    {
//        $response = $this->json('POST', '/api/trade/transbuysell',array(
//            "accessToken"=>$token,
//            "count"=>$count,
//            "no"=>$no,
//            "voucherNo"=>$voucherNo,
//            "paypwd"=>$paypwd
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//
//    }
//
//    protected function tranactionsell($token,$count,$price,$type,$paypwd)
//    {
//        $response = $this->json('POST', '/api/trade/transsell',array(
//            "accessToken"=>$token,
//            "count"=>$count,
//            "price"=>$price,
//            "type"=>$type,
//            "paypwd"=>$paypwd
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//
//    }
//
//    protected function getMessage($token)
//    {
//        $response = $this->json('POST', '/api/user/getmessagelist',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>10
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function getNewType($token)
//    {
//        $response = $this->json('POST', '/api/dic/getnewstype',array(
//            "accessToken"=>$token,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function getNewPushType($token)
//    {
//        $response = $this->json('POST', '/api/dic/getnewspushtype',array(
//            "accessToken"=>$token,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function getNews($token)
//    {
//        $response = $this->json('POST', '/api/user/getnewslist',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>10
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function addNews($token,$data)
//    {
//        $data['data'] = $data;
//        $response = $this->json('POST', '/api/admin/addnews',array(
//            "accessToken"=>$token,
//            "data"=>$data,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();

//    }
//
//    protected function getUserOrder($token)
//    {
//        $response = $this->json('POST', '/api/trade/getorderlist',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>100
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function gettranactionsell($token)
//    {
//        $response = $this->json('POST', '/api/trade/gettranactionsell',array(
//            "accessToken"=>$token,
//            "pageIndex"=>2,
//            "pageSize"=>10,
////            "filters"=>['limit'=>'desc','leveltype'=>'SL01']
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function reg($token)
//    {
//        //用户注册
//        $pwd = "123qwe";
//        $code = '18211149914';
//        $data['loginid'] = 'emo';
//        $data['nickname'] = 'emo';
//        $data['mobile'] = 13263463442;
//        $data['name'] = '周涛';
//        $data['idno'] = '421126199803263816';
//        $data['data'] = $data;
//        $response = $this->json('POST', '/api/auth/reg',array(
//            "accessToken"=>$token,
//            "paypwd"=>"1234qwe",
//            "pwd"=>$pwd,
//            "data"=>$data,
//            "code"=>$code
//        ));
//        dump($response->json());
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//
//        dump('注册成功');
//    }
//
//    protected function getUserCoinAccount($token,$pageSize,$pageIndex)
//    {
//        $response = $this->json('POST', '/api/user/getusercoinlist', array(
//            "accessToken" => $token,
//            "pageSize"=>$pageSize,
//            "pageIndex"=>$pageIndex,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('用户代币账户:');
//        return $response->json();
//    }
//
//    protected function withCoinConfirm($token,$no,$confirm)
//    {
//        $response = $this->json('POST', '/api/coin/withdrawalconfirm', array(
//            "accessToken"=>$token,
//            'no'=>$no,
//            'confirm'=>$confirm,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('提现代币审核完成:');
//        return $response->json();
//    }
//
//    protected function withCoin($token,$amount,$coin_type,$userid,$address,$paypwd)
//    {
//        $response = $this->json('POST', '/api/coin/withdrawal', array(
//            "accessToken" => $token,
//            "amount"=>$amount,
//            "coin_type"=>$coin_type,
//            "userid"=>$userid,
//            "address"=>$address,
//            "paypwd"=>$paypwd
//        ));
//        dump($response->json());
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('提现代币完成:');
//        return $response->json();
//    }
//
//    protected function rachargeCoinConfirm($token,$no,$confirm)
//    {
//        $response = $this->json('POST', '/api/coin/rechargconfirm', array(
//            "accessToken"=>$token,
//            'no'=>$no,
//            'confirm'=>$confirm,
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function rachargeCoin($token,$amount,$coin_type,$userid)
//    {
//        $response = $this->json('POST', '/api/coin/rechagecoin', array(
//            "accessToken" => $token,
//            "amount"=>$amount,
//            "coin_type"=>$coin_type,
//            "userid"=>$userid
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            dump('充值代币完成:');
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function rachargeCoin1($token,$amount,$coin_type,$userid)
//    {
//        $response = $this->json('POST', '/api/coin/rechage', array(
//            "accessToken" => $token,
//            "amount"=>$amount,
//            "coin_type"=>$coin_type,
//            "userid"=>$userid
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            dump('充值代币完成:');
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function getUserAccount($token)
//    {
//        $response = $this->json('POST', '/api/user/getusercashaccount', array(
//            "accessToken" => $token,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('用户现金账户:');
//        return $response->json();
//    }
//
//    protected function rachargeConfirm($token,$no,$confirm)
//    {
//        $response = $this->json('POST','/api/cash/rechargconfirm',[
//            "accessToken"=>$token,
//            'no'=>$no,
//            'confirm'=>$confirm,
//        ]);
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('审核成功');
//        return $response->json();
//    }
//
//    protected function racharge($token,$bankid,$desbankid,$phone,$amount)
//    {
//        $response = $this->json('POST','/api/cash/rechage',[
//            "accessToken"=>$token,
//            'amount'=>$amount,
//            'bankid'=>$bankid,
//            'desbankid'=>$desbankid,
//            'phone'=>$phone
//        ]);
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('充值成功,单据号：');
//        return $response->json()['data'];
//    }
//
//    protected function getSysBankNo($token)
//    {
//        $response = $this->json('POST', '/api/user/getcashbanklist',array(
//            "accessToken"=>$token,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        $desbankid = $response->json()['data']['no'];
//        dump('系统银行卡：');
//        return $desbankid;
//    }
//
//    protected function addUserBank($token,$sysBankType)
//    {
//        $bankType = $sysBankType;
//        $name = '太阳宫支行';
//        $phone = 13263463442;
//        $bankNo = rand(1000000000000000,9999999999999999);
//        $verfy = '337394';
//        $response = $this->json('POST', '/api/user/addbankcard',array(
//            "accessToken"=>$token,
//            "bank_no"=>$bankNo,
//            "bank_name"=>$name,
//            "bank_type"=>$bankType,
//            "phone"=>$phone,
//            "verfy"=>$verfy,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        dump('银行卡绑定Ok');
//        return $bankNo;
//    }
//
//    protected function getSysBank($token)
//    {
//        $response = $this->json('POST', '/api/dic/getbanks',array(
//            "accessToken"=>$token,
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function getUserBank($token)
//    {
//        $response = $this->json('POST', '/api/user/getbankcards',array(
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>10
//
//        ));
//        dd($response->json());
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//        return $response->json();
//    }
//
//    protected function login($user,$token,$type = false)
//    {
//        //用户登陆
////        $user  = 'kk970645';
//        $pwd = '123qwe';
//        $response = $this->json('POST', '/api/auth/login',array(
//            "accessToken"=>$token,
//            "userid"=>$user,
//            "pwd"=>$pwd
//
//        ));
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//
//        $name = $response->json();
//        dump('登陆成功');
//
////        if ($type == 1) {
//            dump($response->json());
//            return $response->json()['data']['id'];
////        }
//
//        if ($type == false) {
////            $user = $this->getUser($token);
////            return $this->login($user,$token,1);
//        }
//    }
//
//    protected function getUser($token)
//    {
//        $pageIndex = rand(1,10);
//        $pageSize = rand(10,12);
//        $index = rand(1,9);
//        $response = $this->json('POST', '/api/admin/getuserlist',[
//            "accessToken"=>$token,
//            "pageIndex"=>$pageIndex,
//            "pageSize"=>$pageSize,
//        ]);
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//
//        $user = $response->json()['data']['items'][$index]['user'];
//        return $user;
//    }
//
//    protected function select($token)
//    {
//        $response = $this->json('POST', '/api/cash/getusercashjournallist',array(
//            "accessToken"=>$token,
//            "pageSize"=>10,
//            "pageIndex"=>1
//
//        ));
//        dump($response->json());
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//    }
//
//    protected function with($token,$bankid,$amount,$paypwd)
//    {
//        $response = $this->json('POST', '/api/cash/withdrawal',array(
//            "accessToken"=>$token,
//            "amount"=>$amount,
//            "bankid"=>$bankid,
//            "paypwd"=>$paypwd
//
//        ));
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function withConfirm($token,$confirm,$desbankid,$withNo)
//    {
//        //        //审核提现
//        $response = $this->json('POST', '/api/cash/withdrawalconfirm', [
//            "accessToken" => $token,
//            'no' => $withNo,
//            'confirm' => $confirm,
//            'desbankid' => $desbankid
//        ]);
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function voucher($token,$coinType,$sellNo)
//    {
//        $response = $this->json('POST', '/api/user/getcashcoinvoucher',[
//            "accessToken"=>$token,
//            "coinType"=>$coinType,
//            "sellNo"=>$sellNo,
//        ]);
//        if (array_key_exists('data',$response->json())) {
//            $response
//                ->assertStatus(200)
//                ->assertJson([
//                    'code' => 0,
//                ]);
//
//            return $response->json();
//        } else {
//            dd($response->json());
//        }
//    }
//
//    protected function userSell($token)
//    {
//        dump('查询所有卖单');
//        $response = $this->json('POST', '/api/user/gettranactionsell',[
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>"10",
//        ]);
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//
//        $no = $response->json()['data'];
//        dump('卖单列表：');
//        dump($no);
//    }
//
//    /**
//     * 查找用户代金券
//     * @param $token
//     */
//    protected function userGetstorage($token)
//    {
//        dump('用户代金券');
//        $filters['status'] = 'VOUS00';
//        $response = $this->json('POST', '/api/user/getstorage',[
//            "accessToken"=>$token,
//            "pageIndex"=>1,
//            "pageSize"=>"10",
//            "filters"=>$filters
//        ]);
//        $response
//            ->assertStatus(200)
//            ->assertJson([
//                'code' => 0,
//            ]);
//
//        $no = $response->json()['data'];
//        dump($no);
//    }
//}
