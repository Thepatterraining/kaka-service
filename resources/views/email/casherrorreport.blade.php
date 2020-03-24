@component('mail::message')

{{$date}} 现金对帐出现错误，具体如下：

    @foreach($res as $value) 

错误：{{$value["error"]}};
    用户目前现金余额：{{$value["cash"]}};
    用户目前现金在途：{{$value["pending"]}};
    用户id：{{$value["userid"]}};
    用户姓名：{{$value["username"]}};
    用户电话：{{$value["mobile"]}};
    @endforeach

请尽快修改！

干活要精,开会要怼,出品要浪,咔咔要发
@endcomponent