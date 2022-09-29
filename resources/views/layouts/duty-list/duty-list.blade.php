@extends('main')
@section('title', __('admin.duty_list'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.duty_list')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{$current_month}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/duty-list">
                        <b-row>
                            <b-col cols="12 mb-3">
                            <span class="mr-2"><i class="fa fa-square text-success mr-1"
                                                  aria-hidden="true"></i>{{__('admin.office_hours')}}</span>
                                <span class="mr-2"><i class="fa fa-square text-warning mr-1"
                                                      aria-hidden="true"></i>{{__('admin.outside_office_hours')}}</span>
                                <span class="mr-2"><i class="fa fa-square text-error mr-1"
                                                      aria-hidden="true"></i>{{__('admin.inside_outside_office_hours')}}</span>
                            </b-col>
                            @foreach(Data::$daysInMonth as $day)
                                <b-col md="12" lg="6" xl="4" class="mb-3">
                                    <div class="duty-list-box">
                                        {!! Tool::generateHeaderOfDutyList($day) !!}
                                        <div class="duty-list-box-users">
                                            <duty-user-tags
                                                    :vars="{{json_encode(['users' => $duty_list->data[$day]['office_hours'] ?? [], 'input_name' => $day. '_office_hours'])}}"></duty-user-tags>
                                        </div>
                                        <div class="duty-list-box-users duty-list-box-users-border-2 ">
                                            <duty-user-tags
                                                    :vars="{{json_encode(['users' => $duty_list->data[$day]['outside_office_hours'] ?? [], 'input_name' => $day . '_outside_office_hours'])}}"></duty-user-tags>
                                        </div>
                                        <div class="duty-list-box-users duty-list-box-users-tech-l1">
                                            <duty-user-tags
                                                    :vars="{{json_encode(['users' => $duty_list->data[$day]['inside_outside_office_hours'] ?? [], 'input_name' => $day . '_inside_outside_office_hours'])}}"></duty-user-tags>
                                        </div>
                                    </div>
                                </b-col>
                                @if($day == $last_day_of_month)
                                    @break
                                @endif
                            @endforeach
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
