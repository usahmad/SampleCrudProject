<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Служба поддержки пользователей</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.sea.css')}}" id="theme-stylesheet">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link rel="manifest" href="/manifest.json">
</head>
<body>

<div class="col-12 col-md-12 col-lg-12">
    <div class="page login-page" style="width: 110%;">
        <div class="container">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <div class="logo text-uppercase"><span>Авторизация</span><strong class="text-primary">
                            <br>
                            Какая то компания</strong></div>
                    <form action="{{ route('login') }}" id="form" method="POST" class="text-left">
                        {{ csrf_field() }}
                        <div class="form-group-material">
                            <input id="login-username" type="text" name="name" required
                                   data-msg="Введите пожалуста Имя пользователя" placeholder="Имя пользователя"
                                   class="input-material">
                        </div>
                        <div class="form-group-material">
                            <input id="login-password" type="password" name="password" required
                                   data-msg="Введите пожалуста Имя пользователя" placeholder="Пароль"
                                   class="input-material">
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" id="login" class="btn btn-primary" value="Войти">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    navigator.serviceWorker.register('sw.js')
        .then(function (registration)
        {
            console.log('Service worker registered successfully');
        }).catch(function (e)
    {
        console.error('Error during service worker registration:', e);
    });
    $(document).ready(function () {
        $("#form").submit(function () {
            $("#login").on('click', function () {
                $("#login").attr("disabled", true);
                return true;
            })
        });
    });
</script>
</body>
</html>
