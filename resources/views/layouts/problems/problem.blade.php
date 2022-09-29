@extends('main')
@section('title', __('admin.problem'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>[{{$id}}] {{$problem->name}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/problems/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.problem_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/problems/problem/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_problem')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">

            @if($problem->active_date && $problem->due_by_date)
                <div class="mb-3">
                    {!! Tool::generateTimeProgressBar($problem->active_date, $problem->due_by_date) !!}
                </div>
            @endif

            @if($option == 'changes')
                @include('layouts.changes.changes-of-object', ['view_link' => '/problems/problem/' . $id])
            @else
                @if($option != 'edit' && $id != 0)
                    @include('layouts.problems.view')
                @else
                    @include('layouts.problems.edit')
                @endif
            @endif
        </b-col>
    </b-row>
@endsection
<script type="application/javascript" defer src="/js/libs/richtext/select-img-r.js"></script>