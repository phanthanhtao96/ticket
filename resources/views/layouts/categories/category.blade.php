@extends('main')
@section('title', __('admin.category'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.category')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2 bt-wrap">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/categories/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.category_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/categories/category/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_category')}}
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
                    <b-form method="post" action="/categories/category">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="100" minlength="3"
                                                  value="{{$category->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.type')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="type">
                                        @foreach(Data::$categoryTypes as $key => $value)
                                            <option value="{{$key}}" {{$category->type == $key ? 'selected' : ''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </b-form-group>
                                <b-form-group label="{{__('admin.description')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="description" rows="5" value="{{$category->description}}"
                                                     maxlength="20000"
                                                     spellcheck="false">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                            </b-col>
                            <b-col cols="12" class="text-right mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                @if($id != 0)
                                    <a class="text-danger mr-2" onclick="return confirm('{{__('admin.are_you_sure')}}')"
                                       href="/categories/del/{{$category->id}}" v-b-tooltip.hover
                                       title="{{__('admin.delete')}}" style="vertical-align: middle">
                                        <b-icon icon="trash"></b-icon>
                                    </a>
                                @endif
                                <b-button type="submit" variant="primary"
                                          class="border-0 main-button">{{__('admin.save')}}
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection