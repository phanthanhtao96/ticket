@extends('main')
@section('title', __('admin.sent_list'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.sent_list')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="sbd-table mb-3 shadow-2 float-left">
                <div class="sbd-row header">
                    <div class="cell cw-70">
                        ID
                    </div>
                    <div class="cell">
                        {{__('admin.name')}}
                    </div>
                    <div class="cell cw-200 cell-9">
                        {{__('admin.sent_date')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($emails as $email)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$email->id}}
                        </div>
                        <div class="cell">
                            <a href="/emails/email/{{$email->id}}">
                                {{$email->name}}
                            </a>
                            <b-badge variant="info"
                                     class="status-{{strtolower($email->type)}} ml-2">{{$email->type}}</b-badge>
                        </div>
                        <div class="cell cw-200 cell-9">
                            {{$email->updated_at}}
                        </div>
                        <div class="cell cell-7">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$emails->links()}}
            </div>
        </b-col>
    </b-row>
@endsection