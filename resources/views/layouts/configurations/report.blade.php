@extends('main')
@section('title', __('admin.report') .' '.__('admin.configuration'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.report') .' '.__('admin.configuration')}}</h1>
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
                    <b-form method="post" action="/configurations/report">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <div class="hr-radius"></div>
                                <h5 class="text-warning">{{__('admin.auto_report')}}</h5>
                                <b-form-group label="{{__('admin.weekday')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="weekday_auto_report">
                                        @foreach(Data::$weekdays as $key => $value)
                                            <option value="{{$key}}" {{$weekday_auto_report == $key ? 'selected' : ''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </b-form-group>
                                <b-form-group label="{{__('admin.time')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-input type="text" name="time_auto_report" value="{{$time_auto_report}}"></b-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.to_emails')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <user-tags
                                            :vars="{{json_encode(['users' => $auto_report_to_emails, 'input_name' => 'auto_report_to_emails'])}}"></user-tags>
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
                    <b-form method="post" action="/configurations/test-report">
                        @csrf
                        <b-button type="submit" variant="primary"
                                  class="border-0 main-button">{{__('admin.test')}}
                        </b-button>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection