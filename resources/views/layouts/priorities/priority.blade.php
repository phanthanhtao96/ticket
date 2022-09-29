@extends('main')
@section('title', __('admin.priority'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.priority')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2 bt-wrap">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/priorities/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.priority_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/priorities/priority/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_priority')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{__('admin.edit')}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/priorities/priority">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="50" minlength="2"
                                                  value="{{$priority->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.level')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="number" name="level" value="{{$priority->level}}"
                                                  min="0" max="100" required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.description')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="description" rows="5" value="{{$priority->description}}"
                                                     maxlength="20000"
                                                     spellcheck="false">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                            </b-col>
                            <b-col cols="12" class="text-right">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <b-button type="submit" variant="primary"
                                          class="border-0 main-button mt-3">{{__('admin.save')}}
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection