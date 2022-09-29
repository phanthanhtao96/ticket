<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="locale" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    <meta name="token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SaoBacDauTelecom">
    <link rel="icon" type="image/png" href="/favicon.png"/>
    <script src="/js/libs/jquery.min.js"></script>
    <link rel="stylesheet"
          href="/js/libs/richtext/icon/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/js/libs/richtext/richtext.css">
    <script src="/js/libs/richtext/jquery.richtext.js"></script>
    <link href="/css/app.css?v={{env('APP_VERSION', '1.0')}}" rel="stylesheet">
    <link href="/css/select2.min.css?v={{env('APP_VERSION', '1.0')}}" rel="stylesheet" />
    <link href="/css/customize.css?v={{env('APP_VERSION', '1.0')}}" rel="stylesheet" />
    <script src="/js/select2.min.js?v={{env('APP_VERSION', '1.0')}}"></script>
    <title>@yield('title')</title>
</head>
<body>
<div id="app" v-cloak>
    @include('header')
    <b-container fluid class="main-container">
        @include('messages')
        @yield('content')
        <b-row class="pt-5 pb-4">
            <b-col class="text-main-color">
                <hr>
                © SaoBacDau Telecom. version {{env('APP_VERSION', '1.0')}}
            </b-col>
        </b-row>
    </b-container>
</div>
<script src="{{env('MIX_PORTAL_EXTEND_SOCKET_HOST', '')}}/socket.io/socket.io.js"></script>
<script src="/js/app.js?v={{env('APP_VERSION', '1.0')}}" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.status-multiselect').select2();
    });
</script>
</body>
</html>
