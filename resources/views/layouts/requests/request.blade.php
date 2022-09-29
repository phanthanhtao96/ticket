@extends('main')
@section('title', __('admin.request'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{$request->active_date ? Tool::getTicketFullName($request->id, $request->name) : $request->name}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/requests/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.request_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/requests/request/0/edit'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_request')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">

            @if($request->active_date && $request->due_by_date && !in_array($request->status, ['Cancelled', 'Closed']))
                <div class="mb-3">
                    {!! Tool::generateTimeProgressBar($request->active_date, $request->due_by_date) !!}
                </div>
            @endif

            @if($option == 'changes')
                @include('layouts.changes.changes-of-object', ['view_link' => '/requests/request/' . $id])
            @else
                @if($option != 'edit' && $id != 0)
                    @include('layouts.requests.view')
                @else
                    @include('layouts.requests.edit')
                @endif
            @endif
        </b-col>
    </b-row>
@endsection
<script type="application/javascript" defer src="/js/libs/richtext/select-img-r.js"></script>