@extends('main')
@section('title', __('admin.configurations'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.configurations')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('configurations-menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{__('admin.edit')}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/configurations">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.office_hours')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-alert show class="same-width">hh:mm-hh:mm,...</b-alert>
                                    <b-form-textarea name="office_hours" rows="2"
                                                     value="{{$office_hours}}"></b-form-textarea>
                                </b-form-group>
                                <b-form-group label="{{__('admin.workdays')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-alert show class="same-width">
                                        1 = monday, 2 = tuesday, 3 = wednesday, 4 = thursday, 5 = friday, 6 = saturday,
                                        7 = sunday
                                    </b-alert>
                                    <b-form-textarea name="workdays" rows="2" value="{{$workdays}}"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                            </b-col>
                            <b-col cols="12" class="text-right mt-3">
                                @csrf
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