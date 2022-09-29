@extends('main')
@section('title', __('admin.roles'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.roles')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/roles/role/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_role')}}
            </b-button>
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.filter')}}</h2>
                </template>
                <b-card-body>
                    <b-input-group class="mt-3">
                        <b-input-group-prepend is-text>
                            <b-icon icon="pen"></b-icon>
                        </b-input-group-prepend>
                        <b-form-input></b-form-input>
                        <b-input-group-append>
                            <b-button variant="primary" class="main-button">{{__('admin.filter')}}</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-card-body>
            </b-card>
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
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($roles as $role)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$role->id}}
                        </div>
                        <div class="cell">
                            <a href="/roles/role/{{$role->id}}">
                                {{$role->name}}
                            </a>
                        </div>
                        <div class="cell cell-7">
                            <a href="/roles/role/{{$role->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$roles->links()}}
            </div>
        </b-col>
    </b-row>
@endsection