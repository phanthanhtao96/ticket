@extends('main')
@section('title', __('admin.email'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.email')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{__('admin.email')}}</h2>
                </template>
                <b-card-body>
                    <b-row>
                        <b-col cols="12">
                            <h1 class="text-warning">{{$email->name}}</h1>
                            <ul class="info-bar">
                                <li><label class="pr-1">{{__('admin.to')}}:</label></li>
                                @foreach($email->to as $item)
                                    <li><label class="pr-1">{{$item}}</label></li>
                                @endforeach
                            </ul>
                            <div class="hr-radius"></div>
                            {!! html_entity_decode($email->content) !!}
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection