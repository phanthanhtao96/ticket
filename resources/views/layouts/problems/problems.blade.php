@extends('main')
@section('title', __('admin.problems'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.problems')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/problems/problem/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_problem')}}
            </b-button>
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.options')}}</h2>
                </template>
                <b-form method="post" action="/problems/list">
                    @csrf
                    <b-card-body>
                        <b-input-group prepend="{{__('admin.status')}}">
                            <select class="custom-select" name="status">
                                <option value="" {{$status == '' ? 'selected' : ''}}>{{__('admin.all')}}</option>
                                @foreach(Data::$requestStatus as $key => $value)
                                    <option value="{{$key}}" {{$status == $key ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </b-input-group>
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
                                <option value="name" {{$filter == 'name' ? 'selected' : ''}}>{{__('admin.subject')}}</option>
                                <option value="content" {{$filter == 'content' ? 'selected' : ''}}>{{__('admin.content')}}</option>
                                <option value="root_cause" {{$filter == 'root_cause' ? 'selected' : ''}}>{{__('admin.root_cause')}}</option>
                            </select>
                            <b-input-group-append>
                                <b-button type="submit" variant="primary"
                                          class="main-button">{{__('admin.filter')}}</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-card-body>
                </b-form>
            </b-card>
            @include('layouts.problems.categories')
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="w-100">
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width {{$status != 'Cancelled+Closed' ? 'main-button' : ''}}"
                          onclick="window.location='/problems/list'">{{__('admin.in_processing')}}
                </b-button>
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width {{$status == 'Cancelled+Closed' ? 'main-button' : ''}}"
                          onclick="window.location='/problems/list/none/none/Cancelled+Closed'">Cancelled, Closed
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
                    <div class="cell cw-140 cell-14">
                        {{__('admin.requester')}}
                    </div>
                    <div class="cell cw-140 cell-9">
                        {{__('admin.assigned_to')}}
                    </div>
                    <div class="cell cw-140 cell-14">
                        {{__('admin.due_time')}}
                    </div>
                    <div class="cell cw-90 cell-7">
                        {{__('admin.priority')}}
                    </div>
                    <div class="cell cw-140 cell-7">
                        {{__('admin.status')}}
                    </div>
                    <div class="cell cw-140 cell-14">
                        {{__('admin.created_at')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($problems as $problem)
                    <div class="sbd-row">
                        <div class="cell cell-5">
                            {{$problem->id}}
                        </div>
                        <div class="cell">
                            <a href="/problems/problem/{{$problem->id}}" class="clearfix">
                                {{$problem->name}}
                            </a>
                        </div>
                        <div class="cell cell-14">
                            <a href="/users/user/{{$problem->requester_id}}" class="text-normal">
                                {{$problem->requester_name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            <a href="/users/user/{{$problem->technician_id}}" class="text-normal">
                                {{$problem->technician_name}}
                            </a>
                        </div>
                        <div class="cell cell-14">
                            <span v-text="$moment('{{$problem->due_by_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @if($problem->active_date && $problem->due_by_date)
                                {!! Tool::generateTimeProgressBar($problem->active_date, $problem->due_by_date, '', 4) !!}
                            @endif
                        </div>
                        <div class="cell cell-7">
                            <b-badge variant="info"
                                     class="status-lv{{strtolower($problem->priority_level > 5 ? 5 : $problem->priority_level)}}">{{$problem->priority_name}}</b-badge>
                        </div>
                        <div class="cell cell-7">
                            <b-badge variant="info"
                                     class="status-{{strtolower($problem->status)}}">{{$problem->status}}</b-badge>
                        </div>
                        <div class="cell cell-14">
                            <span v-text="$moment('{{$problem->created_at}}').format('HH:mm DD/MM/YYYY')"></span>
                        </div>
                        <div class="cell cell-7">
                            <a href="/problems/problem/{{$problem->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$problems->links()}}
            </div>
        </b-col>
    </b-row>
@endsection