@extends('main')
@section('title', __('admin.solution'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>[{{$id}}] {{$solution->name}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/solutions/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.knowledge_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/solutions/solution/0/edit'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_knowledge')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">ID - {{$id}}</h2>
                    @if($option != 'edit')
                        <b-button variant="warning"
                                  class="border-0 btn-sm text-white float-right"
                                  onclick="window.location='/solutions/solution/{{$id}}/edit'">
                            <b-icon icon="pencil-fill"></b-icon>{{__('admin.edit')}}
                        </b-button>
                    @elseif($option == 'edit' && $id != 0)
                        <b-button variant="warning"
                                  class="border-0 btn-sm text-white float-right"
                                  onclick="window.location='/solutions/solution/{{$id}}'">
                            <b-icon icon="eye"></b-icon>{{__('admin.view')}}
                        </b-button>
                    @endif
                </template>
                <b-card-body>
                    @if($option != 'edit' && $id != 0)
                        @include('layouts.solutions.view')
                    @else
                        @include('layouts.solutions.edit')
                    @endif
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection
<script type="application/javascript" defer src="/js/libs/richtext/select-img-r.js"></script>