@component('mail::message')
Hi,{{$name}}

{{$date}}的对帐汇总数据如下：
线下充值总数：{{$res['rechargeOfflineCount']}}
三方充值总数：{{$res['rechargeThirdCount']}}
银行入账总数：{{$res['settlementCount']}}
提现总数：{{$res['withdrawalAllCount']}}
提现成功总数：{{$res['withdrawalCount']}}
交易金额总数：{{$res['tradeCount']}}
三方手续费总数：{{$res['thirdFeeCount']}}
交易手续费总数：{{$res['tradeFeeCount']}}
提现手续费总数：{{$res['withdrawalFeeCount']}}
返佣总数：{{$res['rbBuyCount']}}
理财金总数：{{$res['voucherCount']}}
平台余额总数：{{$res['sumCount']}}
具体明细表稍后在其他邮件中提供附表。
@endcomponent