@extends('main')
@section('title', __('admin.role'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.role')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/roles/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.role_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/roles/role/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_role')}}
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
                    <b-form method="post" action="/roles/role">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="100" minlength="3"
                                                  value="{{$role->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.type')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="type">
                                        @foreach(Data::$roleTypes as $key => $value)
                                            <option value="{{$key}}" {{$role->type == $key ? 'selected' : ''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.level')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="number" name="level" value="{{$role->level}}"
                                                  min="0" max="100" required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label=""
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <div class="checkbox-list">
                                        @foreach(Data::$capabilities as $key => $capability)
                                            <div class="check-row">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="{{$key}}"
                                                           name="capabilities[]"
                                                           value="{{$key}}" {{in_array($key, $role->capabilities) ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="{{$key}}">{{$capability}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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