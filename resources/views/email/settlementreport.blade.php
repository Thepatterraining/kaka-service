@component('mail::message')
Hi,{{$name}}

{{$date}}日的对帐汇总数据如下：

线下充值总数：{{$res['rechargeOfflineCount']}}元

三方充值总数：{{$res['rechargeThirdCount']}}元

银行入账总数：{{$res['settlementCount']}}元

提现总数：{{$res['withdrawalAllCount']}}元

提现成功总数：{{$res['withdrawalCount']}}元

交易金额总数：{{$res['tradeCount']}}元

三方手续费总数：{{$res['thirdFeeCount']}}元

交易手续费总数：{{$res['tradeFeeCount']}}元

提现手续费总数：{{$res['withdrawalFeeCount']}}元

返佣总数：{{$res['rbBuyCount']}}元

理财金总数：{{$res['voucherCount']}}元

用户余额总数：{{$res['userSumCount']}}元

平台余额总数：{{$res['platformSumCount']}} 元

具体明细表稍后在其他邮件中提供附表。

干活要精,开会要怼,出品要浪,咔咔要发
@endcomponent