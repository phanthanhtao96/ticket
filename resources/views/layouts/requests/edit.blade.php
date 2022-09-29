<b-form method="post" action="/requests/request" id="ticket-form">
    <b-card no-body class="shadow-2">
        <template #header>
            <h2 class="mb-0">{{__('admin.edit')}}</h2>
            @if($id != 0)
                <b-button variant="warning"
                          class="border-0 btn-sm text-white float-right"
                          onclick="window.location='/requests/request/{{$id}}'">
                    <b-icon icon="eye"></b-icon>{{__('admin.view')}}
                </b-button>
            @endif
        </template>
        <b-card-body>
            <b-row>
                <b-col cols="12" xl="6">
                    <b-form-group label="{{__('admin.subject')}} (*)"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="name" maxlength="100"
                                      value="{{$request->name}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="{{__('admin.request_type')}} (*)"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="type">
                            @foreach(Data::$requestTypes as $key => $value)
                                <option value="{{$key}}" {{$request->type == $key ? 'selected' : ''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>
                    <b-form-group label="{{__('admin.status')}} (*)"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="status">
                            @foreach(Data::$requestStatus as $key => $value)
                                <option value="{{$key}}" {{$request->status == $key ? 'selected' : ''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>
                    <b-form-group label="{{__('admin.mode')}} (*)"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="mode">
                            @foreach(Data::$requestModes as $key => $value)
                                <option value="{{$key}}" {{$request->mode == $key ? 'selected' : ''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>
                    <b-form-group label="TAC"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="tac" maxlength="100"
                                      value="{{$request->tac}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="SO"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="so" maxlength="100"
                                      value="{{$request->so}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="{{__('admin.so_status')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="so_status">
                            @foreach(Data::$requestSOStatus as $sOStatus)
                                <option value="{{$sOStatus}}" {{$request->so_status == $sOStatus ? 'selected' : ''}}>
                                    {{$sOStatus}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>

                    {{--Requester times--}}
                    <request-times
                            :vars="{{json_encode(['type' => 'Request', 'object' => $request])}}"></request-times>
                </b-col>
                <b-col cols="12" xl="6">
                    <b-form-group label="{{__('admin.flag')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary" class="form-col-layout">
                        <div class="custom-control custom-switch ml-4">
                            <input type="checkbox" class="custom-control-input" id="flagSwitch"
                                   name="flag"
                                   value="1" {{$request->flag == 1 ? 'checked' : ''}}>
                            <label class="custom-control-label" for="flagSwitch"></label>
                        </div>
                    </b-form-group>
                    <b-form-group label="{{__('admin.site')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <select class="custom-select" name="site">
                            @foreach(Data::$sites as $key => $value)
                                <option value="{{$key}}" {{$request->site == $key ? 'selected' : ''}}>
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
                                <option value="{{$category->id}}" {{$request->category_id == $category->id ? 'selected' : ''}}>
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </b-form-group>

                    <request-sla
                            :vars="{{json_encode(['sla_list' => $sla_list, 'priorities' => $priorities, 'sla_id' => $request->sla_id, 'priority_id' => $request->priority_id])}}"></request-sla>

                    <div class="hr-radius"></div>
                    <h5 class="text-warning">{{__('admin.customer')}}</h5>
                    <b-form-group label="{{__('admin.customer_email')}} (*)"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <request-client
                                :vars="{{json_encode(['client_id' => $request->client_id ,'client_email' => $request->client_email])}}"></request-client>
                    </b-form-group>

                    {{--Technician Details--}}
                    <div class="hr-radius"></div>
                    <h5 class="text-warning">{{__('admin.technician')}}</h5>
                    <request-technician :vars="{{json_encode([
                            'request' => $request,
                            'technician' => $technician,
                            'companies' => $companies,
                            'groups' => $groups
                        ])}}"></request-technician>

                    {{--Requester Details--}}
                    @if($request->request_by != 0)
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

                    <div class="hr-radius"></div>
                    <h5 class="text-warning">{{__('admin.device')}}</h5>
                    <b-form-group label="{{__('admin.part_device')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="part_device" maxlength="100"
                                      value="{{$request->part_device}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="{{__('admin.serial_number')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="serial_number" maxlength="100"
                                      value="{{$request->serial_number}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="{{__('admin.tracking_number')}}"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="tracking_number" maxlength="100"
                                      value="{{$request->tracking_number}}">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group label="RMA / DOA"
                                  label-cols="12" label-cols-md="4" label-cols-xl="3"
                                  label-class="text-secondary">
                        <b-form-input type="text" name="rma_doa" maxlength="100"
                                      value="{{$request->rma_doa}}">
                        </b-form-input>
                    </b-form-group>
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
                              required>{{$request->content}}</textarea>
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
                              required>{{$request->root_cause}}</textarea>
                </b-col>
                <b-col cols="12" class="text-right">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="request_by" value="{{$request->request_by}}">
                    <b-button type="button" variant="primary"
                              class="border-0 main-button mt-3 submit-ticket">{{__('admin.save')}}
                    </b-button>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</b-form>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('form#ticket-form').validate({
            rules: {
                type: {
                    required: true,
                },
                site: {
                    required: true,
                },
                mode: {
                    required: true,
                },
                technician_id: {
                    required: true,
                },
                client_id: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                company_id: {
                    required: true,
                },
                group_id: {
                    required: true,
                },
                client_email: {
                    required: true,
                },
                request_by: {
                    required: true,
                },
                sla_id: {
                    required: true,
                },
                status: {
                    required: true,
                },
                name: {
                    required: true,
                },
                priority_id: {
                    required: true,
                },
                post_content: {
                    required: true,
                }
            },
            highlight: function (element) {
                $(element).parent().addClass('error')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('error')
            }
        })
        $('.submit-ticket').on('click', function (e) {
            e.preventDefault()
            $('form#ticket-form').submit()
        })
    })
</script>
