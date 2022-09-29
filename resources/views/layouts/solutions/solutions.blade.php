@extends('main')
@section('title', __('admin.knowledge_list'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.knowledge_list')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/solutions/solution/0/edit'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_knowledge')}}
            </b-button>
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.knowledge_list')}}</h2>
                </template>
                <b-form method="post" action="/solutions/list">
                    @csrf
                    <b-card-body>
                        <b-input-group class="mt-3">
                            <b-input-group-prepend is-text>
                                <b-icon icon="search"></b-icon>
                            </b-input-group-prepend>
                            <b-form-input type="text" name="filter_value"
                                          value="{{$filter_value ?? ''}}"></b-form-input>
                            <b-input-group-append>
                                <b-button type="submit" variant="primary"
                                          class="main-button">{{__('admin.filter')}}</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-card-body>
                </b-form>
            </b-card>
            @include('layouts.solutions.categories')
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="sbd-table mb-5 shadow-2">
                <div class="sbd-row header">
                    <div class="cell cw-70">
                    </div>
                    <div class="cell cw-90 cell-5">
                        ID
                    </div>
                    <div class="cell">
                        {{__('admin.subject')}}
                    </div>
                    <div class="cell cw-200 cell-7">
                        {{__('admin.category')}}
                    </div>
                    <div class="cell cw-140 cell-9">
                        {{__('admin.created_at')}}
                    </div>
                    <div class="cell cw-50 cell-7">
                    </div>
                </div>
                @foreach($solutions as $solution)
                    <div class="sbd-row">
                        <div class="cell">
                        </div>
                        <div class="cell cell-5">
                            {{$solution->id}}
                        </div>
                        <div class="cell">
                            <a href="/solutions/solution/{{$solution->id}}">
                                {{$solution->name}}
                            </a>
                        </div>
                        <div class="cell cell-7">
                            {{$solution->category_name}}
                        </div>
                        <div class="cell cell-9">
                            <span v-text="$moment('{{$solution->created_at}}').format('HH:mm DD/MM/YYYY')"></span>
                        </div>
                        <div class="cell cell-7">
                            <a href="/solutions/solution/{{$solution->id}}">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$solutions->links()}}
            </div>
        </b-col>
    </b-row>
@endsection