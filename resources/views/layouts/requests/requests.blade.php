@extends('main')
@section('title', __('admin.requests'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.requests')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/requests/request/0/edit'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_request')}}
            </b-button>
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.options')}}</h2>
                </template>
                <b-form method="post" action="/requests/list">
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
                                <option value="tac" {{$filter == 'tac' ? 'selected' : ''}}>TAC</option>
                                <option value="name" {{$filter == 'name' ? 'selected' : ''}}>{{__('admin.subject')}}</option>
                                <option value="client_email" {{$filter == 'client_email' ? 'selected' : ''}}>{{__('admin.customer_email')}}</option>
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
            @include('layouts.requests.categories')
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="w-100">
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width"
                          onclick="window.location='/requests/undefined-list'">{{__('admin.undefined_list')}}
                </b-button>
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width {{$status != 'Cancelled+Closed' ? 'main-button' : ''}}"
                          onclick="window.location='/requests/list'">{{__('admin.in_processing')}}
                </b-button>
                <b-button variant="light"
                          class="mb-3 border-0 shadow-2 no-max-width {{$status == 'Cancelled+Closed' ? 'main-button' : ''}}"
                          onclick="window.location='/requests/list/none/none/Cancelled+Closed'">Cancelled, Closed
                </b-button>
            </div>
            <div class="sbd-table mb-5 shadow-2">
                <div class="sbd-row header">
                    <div class="cell cw-70 cell-9">
                    </div>
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
                @foreach($requests as $request)
                    <div class="sbd-row {{$request->active_date == null ? 'sbd-row-hidden' : ''}}">
                        <div class="cell cell-9 text-center">
                            @if($request->mode == 'EMail')
                                <b-icon icon="envelope"></b-icon>
                            @elseif($request->mode == 'PhoneCall')
                                <b-icon icon="telephone"></b-icon>
                            @else
                                <b-icon icon="menu-app"></b-icon>
                            @endif
                            @if($request->flag == 1)
                                <b-icon icon="flag-fill" variant="danger"></b-icon>
                            @endif
                        </div>
                        <div class="cell cell-5">
                            {{$request->id}}
                        </div>
                        <div class="cell">
                            <a href="/requests/request/{{$request->id}}" class="clearfix">
                                @if($request->last_reply)
                                    <b-icon icon="chat-left-dots-fill"
                                            class="text-warning mr-1"></b-icon>@endif
                                    </show-reply-count>{{$request->active_date ? Tool::getTicketFullName($request->id, $request->name) : $request->name}}
                            </a>
                            <small class="text-muted">
                                <b-icon icon="envelope" class="mr-1"></b-icon>{{$request->client_email}}</small>
                        </div>
                        <div class="cell cell-14">
                            <a href="/users/user/{{$request->requester_id}}" class="text-normal">
                                {{$request->requester_name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            <a href="/users/user/{{$request->technician_id}}" class="text-normal">
                                {{$request->technician_name}}
                            </a>
                        </div>
                        <div class="cell cell-14">
                            <span v-text="$moment('{{$request->due_by_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @if($request->active_date && $request->due_by_date && !in_array($request->status, ['Cancelled', 'Closed']))
                                {!! Tool::generateTimeProgressBar($request->active_date, $request->due_by_date, '', 4) !!}
                            @endif
                        </div>
                        <div class="cell cell-7">
                            <b-badge variant="info"
                                     class="status-lv{{strtolower($request->priority_level > 5 ? 5 : $request->priority_level)}}">{{$request->priority_name}}</b-badge>
                        </div>
                        <div class="cell cell-7">
                            <b-badge variant="info"
                                     class="status-{{strtolower($request->status)}}">{{$request->status}}</b-badge>
                        </div>
                        <div class="cell cell-14">
                            <span v-text="$moment('{{$request->active_date}}').format('HH:mm DD/MM/YYYY')"></span>
                        </div>
                        <div class="cell cell-7">
                            <a href="/requests/request/{{$request->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-50 mb-3">
                {{$requests->links()}}
            </div>
            <div class="w-50 mb-3 float-right" style="text-align: right;">
                <button><b>Tổng số Ticket</b>: {{$requests->count()}}</button>
            </div>
        </b-col>
    </b-row>
@endsection
