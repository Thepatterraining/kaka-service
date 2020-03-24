<?php
// api/withoutmid/queue

/*************************    队列   ***********************************/
//队列信息回调
Route::post("version", "\Cybereits\Application\Controller\GetVersion")->middleware('token');
