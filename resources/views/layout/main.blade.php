<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * @var User $user
 */
$user = Auth::user();
$route = Route::currentRouteName();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Служба</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <link rel="stylesheet" href="{{asset('js/main/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.sea.css')}}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
</head>
<body>
<style>
    .word_break{
        word-break: break-all;
    }
    optgroup:empty{display:none}

</style>

<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <div class="sidenav-header-inner text-center">
                <h2 class="h5"> {{$user->name }} </h2>
            </div>
            <div class="sidenav-header-logo"><a class="brand-small text-center"> <strong style="color: #4379BF">{{substr($user->name, 0, 1)}}</strong><strong style="color: #F02965">{{substr($user->name, 1,1)}}</strong></a></div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled" style=" overflow-x: hidden;">
                @foreach(config('menu') as $menu)
                    @if($user->hasPermission($menu['permission']))
                        <li class="{{$route == $menu['permission'] ? "active" : ""}}">
                            <a href="{{route($menu['permission'])}}" class="word_break">
                                <i class="{{$menu['icon']}}"></i>{{$menu['text']}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<div class="page">
    <header class="header">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="fas fa-bars"></i></a><a href="" class="navbar-brand">
                            <div class="brand-text d-none d-md-inline-block"><span>Какая то служба </span></div></a></div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="nav-item dropdown"></li>
                        <li class="nav-item dropdown"></li>
                        <li class="nav-item dropdown"></li>
                        <li class="nav-item">
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div>
        @include('shared.messages')
        <h2 class="no-print">@yield('page-title')</h2>
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p>Netco Telecom &copy; 2015 - {{date('Y')}}</p>
                </div>
                <div class="col-sm-6 text-right">
                    <p>
                        Design by <a href="https://bootstrapious.com/p/bootstrap-4-dashboard" class="external">Bootstrapious</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script>

    /**
     * By Victor - Front-
     */
    $(function () {
        $("[data-collapse]").each(function (idx, elem) {
            const selector = $(elem).attr('href');
            const isShow = window.localStorage.getItem(selector);
            $(selector)
                .collapse(isShow ? 'show' : 'hide')
                .on("shown.bs.collapse", function() {
                    window.localStorage.setItem(selector, 'true');
                })
                .on("hidden.bs.collapse", function() {
                    window.localStorage.removeItem(selector);
                });
        });
    });
    /**
     * End
     */
    $("#logout").on('click', function () {
        $.ajax({
            type: "GET",
            url: '/ajax/logout',
            success: function (res) {
            }
        });
    });


</script>
<script src="{{asset('js/popper.js/esm/popper.min.js')}}"> </script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/grasp_mobile_progress_circle-1.0.0.min.js')}}"></script>
<script src="{{asset('js/jquery.cookie.js')}}"></script>
<script src="{{asset('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('js/main/fontawesome.js')}}"></script>
<script src="{{asset('js/front.js')}}"></script>
<script src="{{asset('js/main/shv.js')}}"></script>
<script src="{{asset('js/main/respond.js')}}"></script>
@stack('scripts')
</body>
</html>
