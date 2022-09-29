@extends('main')
@section('title', __('admin.users'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.users')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/users/user/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_user')}}
            </b-button>
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.filter')}}</h2>
                </template>
                <b-form method="post" action="/users/list">
                    @csrf
                    <b-card-body>
                        <b-input-group class="mt-3">
                            <b-input-group-prepend is-text>
                                <b-icon icon="search"></b-icon>
                            </b-input-group-prepend>
                            <b-form-input type="text" name="filter_value"
                                          value="{{$filter_value ?? ''}}"></b-form-input>
                        </b-input-group>
                        <b-input-group class="mt-3">
                            <select class="custom-select" name="filter">
                                <option value="id" {{$filter == 'id' ? 'selected' : ''}}>ID</option>
                                <option value="name" {{$filter == 'name' ? 'selected' : ''}}>{{__('admin.name')}}</option>
                                <option value="email" {{$filter == 'email' ? 'selected' : ''}}>{{__('admin.email')}}</option>
                            </select>
                            <b-input-group-append>
                                <b-button type="submit" variant="primary"
                                          class="main-button">{{__('admin.filter')}}</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-card-body>
                </b-form>
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
                    <div class="cell cw-240 cell-14">
                        {{__('admin.email')}}
                    </div>
                    <div class="cell cw-180 cell-7">
                        {{__('admin.phone')}}
                    </div>
                    <div class="cell cw-240 cell-14">
                        {{__('admin.company')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($users as $user)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$user->id}}
                        </div>
                        <div class="cell">
                            <a href="/users/user/{{$user->id}}">
                                {{$user->name}}
                            </a>
                        </div>
                        <div class="cell cell-14">
                            {{$user->email}}
                        </div>
                        <div class="cell cell-7">
                            {{$user->phone}}
                        </div>
                        <div class="cell cell-7">
                            {{$companies[$user->company_id] ?? 'Undefined'}}
                        </div>
                        <div class="cell cell-7">
                            <a href="/users/user/{{$user->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$users->links()}}
            </div>
        </b-col>
    </b-row>
@endsection
