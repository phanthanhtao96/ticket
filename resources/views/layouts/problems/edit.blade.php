<b-form method="post" action="/problems/problem">
    <b-card no-body class="shadow-2">
        <template #header>
            <h2 class="mb-0">{{__('admin.edit')}}</h2>
            @if($id != 0)
                <b-button variant="warning"
                          class="border-0 btn-sm text-white float-right"
                          onclick="window.location='/problems/problem/{{$id}}'">
                    <b-icon icon="eye"></b-icon>{{__('admin.view')}}
                </b-button>
            @endif
        </template>
        <b-card-body>
            <b-row>
                <b-col cols="12" xl="6">
                    <b-form-group label="{{__('admin.subject')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="name" maxlength="100"
                                      value="{{$problem->name}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="{{__('admin.status')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="status">
                            @foreach(Data::$problemStatus as $key => $value)
                                <option value="{{$key}}" {{$problem->status == $key ? 'selected' : ''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>

                    {{--Requester times--}}
                    <request-times
                            :vars="{{json_encode(['type' => 'Problem', 'object' => $problem])}}"></request-times>
                </b-col>
                <b-col cols="12" xl="6">
                    <b-form-group label="{{__('admin.flag')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary" class="form-col-layout">
                        <div class="custom-control custom-switch ml-4">
                            <input type="checkbox" class="custom-control-input" id="flagSwitch"
                                   name="flag"
                                   value="1" {{$problem->flag == 1 ? 'checked' : ''}}>
                            <label class="custom-control-label" for="flagSwitch"></label>
                        </div>
                    </b-form-group>
                    <b-form-group label="{{__('admin.site')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="site">
                            @foreach(Data::$sites as $key => $value)
                                <option value="{{$key}}" {{$problem->site == $key ? 'selected' : ''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>
                    <b-form-group label="{{__('admin.category')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$problem->category_id == $category->id ? 'selected' : ''}}>
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>

                    <request-sla
                            :vars="{{json_encode(['sla_list' => $sla_list, 'priorities' => $priorities, 'sla_id' => $problem->sla_id, 'priority_id' => $problem->priority_id])}}"></request-sla>
                    {{--<b-form-group label="{{__('admin.sla')}}"--}}
                    {{--label-cols="12" label-cols-md="4" label-cols-xl="3"--}}
                    {{--label-class="text-secondary">--}}
                    {{--<select class="custom-select" name="sla_id">--}}
                    {{--@foreach($sla_list as $sla)--}}
                    {{--<option value="{{$sla->id}}" {{$problem->sla_id == $sla->id ? 'selected' : ''}}>--}}
                    {{--{{$sla->name}}--}}
                    {{--</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</b-form-group>--}}
                    {{--<b-form-group label="{{__('admin.priority')}}"--}}
                    {{--label-cols="12" label-cols-md="4" label-cols-xl="3"--}}
                    {{--label-class="text-secondary">--}}
                    {{--<select class="custom-select" name="priority_id">--}}
                    {{--@foreach($priorities as $priority)--}}
                    {{--<option value="{{$priority->id}}" {{$problem->priority_id == $priority->id ? 'selected' : ''}}>--}}
                    {{--{{$priority->name}}--}}
                    {{--</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</b-form-group>--}}

                    {{--Technician Details--}}
                    <div class="hr-radius"></div>
                    <h5 class="text-warning">{{__('admin.technician')}}</h5>
                    <request-technician :vars="{{json_encode([
                            'request' => $problem,
                            'technician' => $technician,
                            'companies' => $companies,
                            'groups' => $groups
                        ])}}"></request-technician>

                    {{--Requester Details--}}
                    @if($problem->request_by != 0)
                        <div class="hr-radius"></div>
                        <h5 class="text-warning">{{__('admin.requested_by')}}</h5>
                        <b-form-group label="{{__('admin.email')}}"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-input type="email" name="" maxlength="50" minlength="8"
                                          value="{{$requester->email}}" readonly>
                            </b-form-input>
                        </b-form-group>
                        <b-form-group label="{{__('admin.name')}}"
                                      label-cols="12" label-cols-md="4" label-cols-xl="3"
                                      label-class="text-secondary">
                            <b-form-input type="text" name="" maxlength="100" minlength="3"
                                          value="{{$requester->name}}" readonly>
                            </b-form-input>
                        </b-form-group>
                    @endif
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
    <b-card no-body class="shadow-2 mt-3">
        <template #header>
            <h2 class="mb-0">{{__('admin.root_cause')}}</h2>
        </template>
        <b-card-body>
            <b-row>
                <b-col cols="12">
                    <textarea class="cause" name="root_cause" spellcheck="false"
                              required>{{$problem->root_cause}}</textarea>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
    <b-card no-body class="shadow-2 mt-3">
        <template #header>
            <h2 class="mb-0">{{__('admin.content')}}</h2>
        </template>
        <b-card-body>
            <b-row>
                <b-col cols="12">
                    <textarea class="content" name="post_content" spellcheck="false"
                              required>{{$problem->content}}</textarea>
                </b-col>
                <b-col cols="12" class="text-right">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="request_by" value="{{$problem->request_by}}">
                    <b-button type="submit" variant="primary"
                              class="border-0 main-button mt-3">{{__('admin.save')}}
                    </b-button>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</b-form>