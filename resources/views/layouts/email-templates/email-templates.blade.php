@extends('main')
@section('title', __('admin.email_templates'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.email_templates')}}</h1>
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
                        {{__('admin.type')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($email_templates as $email_template)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$email_template->id}}
                        </div>
                        <div class="cell">
                            <a href="/email-templates/email-template/{{$email_template->id}}">
                                {{$email_template->name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            {{$email_template->type}}
                        </div>
                        <div class="cell cell-7">
                            <a href="/email-templates/email-template/{{$email_template->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$email_templates->links()}}
            </div>
        </b-col>
    </b-row>
@endsection