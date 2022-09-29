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
    <title>{{__('admin.rating')}}</title>
</head>
<body>
<div id="app" v-cloak>
    <b-container fluid class="main-container">
        <b-row class="pt-5 pb-4">
            <b-col cols="12" class="text-main-color text-center">
                <client-rating
                        :vars="{{json_encode(['enable' => $enable,'id' => $id, 'email' => $email])}}"></client-rating>
            </b-col>
            <b-col cols="12" class="text-main-color text-center">
                <hr>
                © SaoBacDau Telecom. version {{env('APP_VERSION', '1.0')}}
            </b-col>
        </b-row>
    </b-container>
</div>
<script src="/js/app.js?v={{env('APP_VERSION', '1.0')}}" type="text/javascript" charset="UTF-8"></script>
</body>
</html>