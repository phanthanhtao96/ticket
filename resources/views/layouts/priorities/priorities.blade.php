@extends('main')
@section('title', __('admin.priorities'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.priorities')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/priorities/priority/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_priority')}}
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
                    <div class="cell cw-160 cell-9">
                        {{__('admin.level')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($priorities as $priority)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$priority->id}}
                        </div>
                        <div class="cell">
                            <a href="/priorities/priority/{{$priority->id}}">
                                {{$priority->name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            {{$priority->level}}
                        </div>
                        <div class="cell cell-7">
                            <a href="/priorities/priority/{{$priority->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$priorities->links()}}
            </div>
        </b-col>
    </b-row>
@endsection