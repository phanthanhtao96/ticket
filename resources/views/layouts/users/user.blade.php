@extends('main')
@section('title', __('admin.user'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.users')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2 bt-wrap">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/users/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.user_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/users/user/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_user')}}
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
                    <b-form method="post" action="/users/user">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.disable')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary" class="form-col-layout">
                                    <div class="custom-control custom-switch ml-4">
                                        <input type="checkbox" class="custom-control-input" id="disableSwitch"
                                               name="disable"
                                               value="1" {{$user->disable == 1 ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="disableSwitch"></label>
                                    </div>
                                </b-form-group>
                                <b-form-group label="{{__('admin.email')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="email" name="email" maxlength="50" minlength="8"
                                                  value="{{$user->email}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.password')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="password" name="password" maxlength="20"
                                                  minlength="6" {{$id == 0 ? 'required' : ''}}>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.password_confirm')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="password" name="password_confirmation" maxlength="20"
                                                  minlength="6" {{$id == 0 ? 'required' : ''}}>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="100" minlength="3"
                                                  value="{{$user->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.job_title')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="job_title" maxlength="100" minlength="3"
                                                  value="{{$user->job_title}}">
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.phone')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="phone" maxlength="15" minlength="10"
                                                  value="{{$user->phone}}"
                                                  pattern="[0-9]{9,20}" required>
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.role')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="role_id">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected' : ''}}>
                                                {{$role->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </b-form-group>
                                <b-form-group label="{{__('admin.company')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="company_id">
                                        <option value="0">-- Select company --</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}" {{$user->company_id == $company->id ? 'selected' : ''}}>
                                                {{$company->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </b-form-group>
                                <b-form-group label="{{__('admin.region')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="region">
                                        @foreach(Data::$regions as $key => $value)
                                            <option value="{{$key}}" {{$user->region == $key ? 'selected' : ''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </b-form-group>

                                {{--<b-form-group label="{{__('admin.department')}}"--}}
                                              {{--label-cols="12" label-cols-md="4" label-cols-xl="3"--}}
                                              {{--label-class="text-secondary">--}}
                                    {{--<select class="custom-select" name="department_id">--}}
                                        {{--@foreach($departments as $department)--}}
                                            {{--<option value="{{$department->id}}" {{$user->department_id == $department->id ? 'selected' : ''}}>--}}
                                                {{--{{$department->name}}--}}
                                            {{--</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</b-form-group>--}}
                                <input type="hidden" name="department_id" value="2">

                                <b-form-group label="{{__('admin.groups')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <div class="checkbox-list">
                                        @foreach($groups as $group)
                                            <div class="check-row">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="{{$group->id}}"
                                                           name="groups[]"
                                                           value="{{$group->id}}" {{in_array($group->id, $user->groups) ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="{{$group->id}}">{{$group->name}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </b-form-group>
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
