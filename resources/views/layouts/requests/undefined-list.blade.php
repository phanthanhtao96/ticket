@extends('main')
@section('title', __('admin.requests'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.undefined_list')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="w-100">
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width main-button"
                          onclick="window.location='/requests/undefined-list'">{{__('admin.undefined_list')}}
                </b-button>
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width"
                          onclick="window.location='/requests/list'">{{__('admin.in_processing')}}
                </b-button>
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width"
                          onclick="window.location='/requests/list/none/none/Cancelled+Closed'">Cancelled, Closed
                </b-button>
            </div>
            <div class="sbd-table mb-5 shadow-2">
                <div class="sbd-row header">
                    <div class="cell cw-90 cell-5">
                        ID
                    </div>
                    <div class="cell">
                        {{__('admin.subject')}}
                    </div>
                    <div class="cell cw-140 cell-12">
                        {{__('admin.received_time')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($requests as $request)
                    <div class="sbd-row {{$request->active_date == null ? 'sbd-row-hidden' : ''}}">
                        <div class="cell cell-5">
                            {{$request->id}}
                        </div>
                        <div class="cell">
                            <a href="/requests/request/{{$request->id}}" class="clearfix">
                                {{$request->name}}
                            </a>
                            <small class="text-muted"><b-icon icon="envelope" class="mr-1"></b-icon>{{$request->client_email}}</small>
                        </div>
                        <div class="cell cell-12">
                            <span v-text="$moment('{{$request->created_at}}').format('HH:mm DD/MM/YYYY')"></span>
                        </div>
                        <div class="cell cell-7">
                            <a href="/requests/request/{{$request->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$requests->links()}}
            </div>
        </b-col>
    </b-row>
@endsection