<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>

    </style>
</head>
<body>
@include('_inc.header')

<div class="container">
    @yield('content')
</div>

@include('_inc.footer')
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    function time(){
        $.get('/tool/time',function(data){
            console.log(data.timestamp);
        });
    }

</script>
</html>
