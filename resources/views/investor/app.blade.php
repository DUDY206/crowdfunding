<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon.png">
    <link rel="stylesheet" href="/investor/css/style.css" />
    <script src="{{asset('/bower_components/jquery/dist/jquery.js')}}" ></script>
    <link rel="stylesheet" href="{{asset('/bower_components/Font-Awesome/css/all.min.css')}}">

    <title>{{env('APP_NAME')}}</title>
    @yield('css')
</head>
<body >
<div id="app" >
    <router-view></router-view>
</div>
<script src="{{ asset('investor/js/app.js?v='.time()) }}" defer></script>
{{--<script src="/admin/js/main.js" ></script>--}}
</body>
</html>
