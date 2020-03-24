<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form method="post" enctype="multipart/form-data" >
        {{ csrf_field() }} 
    <input type="file" name="file">
    <input type="text" name="filename">
    <input type="text" name="modelid">
    <input type="text" name="itemid">
    <button type="submit"> 提交 </button>
</form>
    </body>
</html>
