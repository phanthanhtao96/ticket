@extends('main')
@section('title', __('admin.sla'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.sla')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2 bt-wrap">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/sla/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.sla_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/sla/edit/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_sla')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            @if($option == 'changes')
                @include('layouts.changes.changes-of-object', ['view_link' => '/sla/edit/' . $id])
            @else
                <b-card no-body class="shadow-2">
                    <template #header>
                        <h2 class="mb-0">{{__('admin.edit')}}</h2>
                        <b-button variant="warning"
                                  class="border-0 btn-sm text-white float-right ml-1"
                                  onclick="window.location='/sla/edit/{{$id}}'">
                            <b-icon icon="pencil-fill"></b-icon>{{__('admin.edit')}}
                        </b-button>
                        <b-button variant="info"
                                  class="border-0 btn-sm text-white float-right ml-1"
                                  onclick="window.location='/sla/edit/{{$id}}/changes'">
                            <b-icon icon="clock"></b-icon>{{__('admin.changes')}}
                        </b-button>
                    </template>
                    <b-card-body>
                        <b-form method="post" action="/sla/edit">
                            <b-row>
                                <b-col cols="12" xl="8">
                                    <b-form-group label="{{__('admin.name')}} (*)"
                                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                                  label-class="text-secondary">
                                        <b-form-input type="text" name="name" maxlength="50" minlength="3"
                                                      value="{{$sla->name}}"
                                                      required>
                                        </b-form-input>
                                    </b-form-group>
                                    <b-form-group label="{{__('admin.description')}}"
                                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                                  label-class="text-secondary">
                                        <b-form-textarea name="description" rows="5" value="{{$sla->description}}"
                                                         maxlength="20000"
                                                         spellcheck="false">
                                        </b-form-textarea>
                                    </b-form-group>
                                    <b-form-group label="{{__('admin.priority')}} (*)"
                                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                                  label-class="text-secondary">
                                        <select class="custom-select" name="priority_id">
                                            @foreach($priorities as $priority)
                                                <option value="{{$priority->id}}" {{$sla->priority_id == $priority->id ? 'selected' : ''}}>
                                                    {{$priority->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </b-form-group>
                                    <b-form-group
                                            label="{{__('admin.request_responded_within')}} ({{__('admin.minutes')}})"
                                            label-cols="12" label-cols-md="4" label-cols-xl="3"
                                            label-class="text-secondary">
                                        <b-form-input type="number" name="max_response_time"
                                                      value="{{$sla->max_response_time}}"
                                                      placeholder="{{__('admin.minutes')}}"
                                                      min="0" max="100000">
                                        </b-form-input>
                                    </b-form-group>
                                    <b-form-group
                                            label="{{__('admin.request_resolved_within')}} ({{__('admin.minutes')}})"
                                            label-cols="12" label-cols-md="4" label-cols-xl="3"
                                            label-class="text-secondary">
                                        <b-form-input type="number" name="max_resolve_time"
                                                      value="{{$sla->max_resolve_time}}"
                                                      placeholder="{{__('admin.minutes')}}"
                                                      min="0" max="100000">
                                        </b-form-input>
                                    </b-form-group>

                                    <div class="hr-radius w-100"></div>
                                    <h5 class="text-warning">{{__('admin.response_rules')}}</h5>
                                    <sla-ruler :vars="{{json_encode([
                                        'rule_type' => 'Response',
                                        'sla_id'=> $id,
                                        'data_column' => 'response_data',
                                        'level' => 1,
                                        'role_types' => Data::$roleTypes,
                                        'role_type' => 'TechnicianL1',
                                        'time_types' => Data::$slaTimeTypes,
                                        'time_type' => 'After',
                                        'difference_time' => 0,
                                        'actions' => Data::$slaActions,
                                        'action' => 'Notification',
                                        'email_types' => Data::$slaResponseEmailTypes,
                                        'email_type' => 'ResponseReminderEmail',
                                        'rules' => $sla->response_data ?? []
                                    ])}}"></sla-ruler>

                                    <div class="hr-radius w-100"></div>
                                    <h5 class="text-warning">{{__('admin.escalate_rules')}}</h5>
                                    @foreach(Data::$slaLevels as $levelKey => $levelData)
                                        @if($levelKey > 1)
                                            @php
                                                if($id == 0) $slaA = (array)$sla;
                                            @endphp
                                            <div class="hr-radius bg-secondary"></div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="Switch{{$levelKey}}"
                                                       name="enable_levels[]"
                                                       value="{{$levelKey}}" {{in_array($levelKey, $id == 0 ? $slaA['enable_levels'] : $sla['enable_levels']) ? 'checked' : ''}}>
                                                <label class="custom-control-label text-warning"
                                                       for="Switch{{$levelKey}}">{{$levelData['label']}}</label>
                                            </div>
                                            <b-form-group
                                                    label="{{__('admin.escalate_after')}} ({{__('admin.minutes')}}) (*)"
                                                    label-cols="12" label-cols-md="4" label-cols-xl="3"
                                                    label-class="text-secondary" hidden>
                                                <b-form-input type="number" name="{{$levelData['time_column']}}"
                                                              value="{{$id == 0 ? $slaA[$levelData['time_column']] : $sla[$levelData['time_column']]}}"
                                                              placeholder="{{__('admin.minutes')}}"
                                                              min="0" max="100000">
                                                </b-form-input>
                                            </b-form-group>
                                            <sla-ruler :vars="{{json_encode([
                                                'rule_type' => 'Resolve',
                                                'sla_id'=> $id,
                                                'data_column' => $levelData['data_column'],
                                                'level' => $levelKey,
                                                'role_types' => Data::$roleTypes,
                                                'role_type' => $levelData['tech_key'],
                                                'time_types' => Data::$slaTimeTypes,
                                                'time_type' => 'After',
                                                'difference_time' => $levelData['difference_time'],
                                                'actions' => Data::$slaActions,
                                                'action' => $levelData['action'],
                                                'email_types' => Data::$slaEmailTypes,
                                                'email_type' => $levelData['email_type'],
                                                'rules' => $id == 0 ? $slaA[$levelData['data_column']] : $sla[$levelData['data_column']]])}}">
                                            </sla-ruler>
                                        @endif
                                    @endforeach

                                </b-col>
                                <b-col cols="12" xl="4">
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
            @endif
        </b-col>
    </b-row>
@endsection
