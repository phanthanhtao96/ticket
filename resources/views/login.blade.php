<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="locale" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    <meta name="token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SaoBacDauTelecom">
    <link rel="icon" type="image/png" href="/favicon.png"/>
    <link href="/css/app.css?v={{env('APP_VERSION', '1.0')}}" rel="stylesheet">
    <title>{{__('admin.login')}}</title>
</head>
<body>
<div id="app" v-cloak>
    @include('messages')
    <section>
        <b-card class="login-wrap">
            {{--<b-form action="{{route('login')}}" method="post">--}}
                <a href="/">
                    <b-aspect aspect="1:1" class="logo-box mb-4 horizontal-center">
                        <img src="/images/sbd.svg">
                    </b-aspect>
                </a>
                {{--<b-input-group class="mb-3 shadow-2">--}}
                    {{--<b-input-group-prepend is-text>--}}
                        {{--<b-icon icon="person-square" variant="secondary"></b-icon>--}}
                    {{--</b-input-group-prepend>--}}
                    {{--<b-form-input type="email" name="email" required>--}}
                    {{--</b-form-input>--}}
                {{--</b-input-group>--}}
                {{--<b-input-group class="mb-3 shadow-2">--}}
                    {{--<b-input-group-prepend is-text>--}}
                        {{--<b-icon icon="key" variant="secondary"></b-icon>--}}
                    {{--</b-input-group-prepend>--}}
                    {{--<b-form-input type="password" name="password" minlength="8">--}}
                    {{--</b-form-input>--}}
                {{--</b-input-group>--}}
                {{--<b-button type="submit" variant="primary" class="w-100 mb-3 main-button shadow-2">--}}
                    {{--{{__('admin.login')}}--}}
                {{--</b-button>--}}
                <b-button type="submit" variant="light" class="w-100 shadow-2" onclick="window.location='/ms-login'">
                    {{__('admin.login_with')}} <img src="/images/microsoft-logo.svg">
                </b-button>
                {{--@csrf--}}
            {{--</b-form>--}}
        </b-card>
    </section>
</div>
<script src="/js/app.js?v={{env('APP_VERSION', '1.0')}}" type="text/javascript" charset="UTF-8"></script>
</body>
</html>