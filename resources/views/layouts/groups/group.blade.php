@extends('main')
@section('title', __('admin.group'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.group')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/groups/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.group_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/groups/group/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_group')}}
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
                    <b-form method="post" action="/groups/group">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="100" minlength="3"
                                                  value="{{$group->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.level')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="number" name="level" value="{{$group->level}}"
                                                  min="0" max="100" required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.technician')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary" class="form-col-layout">
                                    <div class="custom-control custom-switch ml-4">
                                        <input type="checkbox" class="custom-control-input" id="technicianSwitch"
                                               name="technician"
                                               value="1" {{$group->technician == 1 ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="technicianSwitch"></label>
                                    </div>
                                </b-form-group>
                                <b-form-group label="{{__('admin.description')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="description" rows="3"
                                                     value="{{$group->description}}"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                            </b-col>
                            <b-col cols="12" class="text-right mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                @if($id != 0)
                                    <a class="text-danger mr-2" onclick="return confirm('{{__('admin.are_you_sure')}}')"
                                       href="/groups/del/{{$group->id}}" v-b-tooltip.hover
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