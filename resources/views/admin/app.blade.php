<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo.png') }}">
{{--    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">--}}
{{--    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">--}}
{{--    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">--}}
{{--    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>--}}
{{--    </script>--}}
    <link rel="stylesheet" href="{{ asset('/admin/css/style.css?v='.time()) }}" />
    <link rel="stylesheet" href="{{ asset('/bower_components/Font-Awesome/css/all.min.css?v='.time()) }}">
    <script src="{{ asset('/bower_components/jquery/dist/jquery.js?v='.time()) }}" ></script>
    
    <title>BestB Crowdfunding</title>
    @yield('css')
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>
<script src="{{ asset('admin/js/app.js?v='.time()) }}" defer></script>
{{--<script src="/admin/js/main.js" ></script>--}}
</body>
</html>
