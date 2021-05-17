<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('investor/css/style.css?v='.time()) }}" />
    <script src="{{ asset('/bower_components/jquery/dist/jquery.js') }}" ></script>
    <link rel="stylesheet" href="{{ asset('/bower_components/Font-Awesome/css/all.min.css?v='.time()) }}">

    <title>{{env('APP_NAME')}}</title>
    @yield('css')
</head>
<body ontouchstart>
<div id="app" >
    <router-view></router-view>
</div>
<script src="{{ asset('investor/js/app.js?v='.time()) }}" defer></script>

<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
        xfbml: true,
        version: 'v10.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Your Plugin chat code -->
<div
    class="fb-customerchat"
    attribution="biz_inbox"
    page_id="107915990888324"
    theme_color="#161D2D"
    logged_in_greeting="Xin chào! Bạn đang tìm hiểu vấn đề gì? Chúng tôi sẽ tư vấn giúp bạn!"
    logged_out_greeting="Xin chào! Bạn đang tìm hiểu vấn đề gì? Chúng tôi sẽ tư vấn giúp bạn!"
>
</div>

{{--<script src="/admin/js/main.js" ></script>--}}
</body>
</html>
