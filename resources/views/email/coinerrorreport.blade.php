@component('mail::message')

{{$date}} 代币对帐出现错误，具体如下：

    @foreach($res as $value) 
    @if($value["error"]=="代币在途为负")
错误：{{$value["error"]}};
    相关代币类型：{{$value["type"]}};
    用户目前代币在途：{{$value["pending"]}};
    用户id：{{$value["userid"]}};
    用户姓名：{{$value["username"]}};
    用户电话：{{$value["mobile"]}};
    @else
错误：{{$value["error"]}};
    相关代币类型：{{$value["type"]}};
    目前用户代币总数：{{$value["coinaccount"]}};
    实际发行代币总数：{{$value["account"]}};
    @endif
    @endforeach

请尽快修改！

干活要精,开会要怼,出品要浪,咔咔要发
@endcomponent