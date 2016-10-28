<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style>

    </style>
</head>
<body>


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-heading">仪表盘</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ url('sso/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="forward" value="{{ session('forward') }}">
                            <input type="text" name="email" value="">
                            <input type="text" name="password" value="">
                            <input type="submit" value="login and set cookie">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>