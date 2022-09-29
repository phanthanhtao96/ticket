@extends('main')
@section('title', __('admin.sla_list'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.sla_list')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/sla/edit/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_sla')}}
            </b-button>
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
                    <div class="cell cell-9">
                        {{__('admin.description')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($sla_list as $sla)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$sla->id}}
                        </div>
                        <div class="cell">
                            <a href="/sla/edit/{{$sla->id}}">
                                {{$sla->name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            {{$sla->description}}
                        </div>
                        <div class="cell cell-7">
                            <a href="/sla/edit/{{$sla->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$sla_list->links()}}
            </div>
        </b-col>
    </b-row>
@endsection