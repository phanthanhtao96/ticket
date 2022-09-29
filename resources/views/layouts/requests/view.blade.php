<b-card no-body class="shadow-2">
    <template #header>
        <h2 class="mb-0">{{__('admin.view')}}</h2>
        <b-button variant="warning"
                  class="border-0 btn-sm text-white float-right ml-1"
                  onclick="window.location='/requests/request/{{$id}}/edit'">
            <b-icon icon="pencil-fill"></b-icon>{{__('admin.edit')}}
        </b-button>
        <b-button variant="info"
                  class="border-0 btn-sm text-white float-right ml-1"
                  onclick="window.location='/requests/request/{{$id}}/changes'">
            <b-icon icon="clock"></b-icon>{{__('admin.changes')}}
        </b-button>
    </template>
    <b-card-body>
        <b-row>
            <b-col cols="12" class="mb-4">
                <h1 class="text-warning"
                    class="mb-1">{{$request->active_date ? Tool::getTicketFullName($request->id, $request->name) : $request->name}}</h1>
                <ul class="info-bar">
                    @if($request->flag == 1)
                        <li>
                            <b-icon icon="flag-fill" variant="danger"></b-icon>
                        </li>
                    @endif
                    <li><label class="pr-1">{{__('admin.requested_by')}}:</label><a
                                href="/users/user/{{$requester->id}}">
                            {{$requester->name}}</a></li>
                    <li><label class="pr-1">{{__('admin.technician')}}:</label><a
                                href="/users/user/{{$technician->id}}">
                            {{$technician->name}}</a></li>
                    <li><label class="pr-1">{{__('admin.due_date')}}:</label>
                        {{$request->due_by_date}}</li>
                    <li><label class="pr-1">{{__('admin.status')}}:</label>
                        {{$request->status}}</li>
                    <li><label class="pr-1">{{__('admin.priority')}}:</label>
                        {{$request->priority_name}}</li>
                    <li><label class="pr-1">{{__('admin.customer_email')}}:</label>
                        {{$request->client_email}}</li>
                    <li><label class="pr-1">{{__('admin.customer_company')}}:</label>
                        {{$customer_company[$request->client_email] ?? ''}}</li>
                </ul>
                @if($rating)
                    <b-container fluid class="main-container">
                        <b-row class="pt-5 pb-4">
                            <b-col cols="12" class="text-main-color text-center">
                                <client-rating
                                        :vars="{{json_encode(['rating' => $rating,'is_view' => 1, 'enable' => 1,'id' => $request->id, 'email' => $request->client_email])}}"></client-rating>
                            </b-col>
                        </b-row>
                    </b-container>
                @endif
                <div class="hr-radius"></div>

                @if($request->content)
                    <div class="w-100 mt-2 html-content" v-pre>
                        <h5 class="text-info">{{__('admin.content')}}</h5>
                        {!! $request->content !!}
                        <hr>
                    </div>
                @endif

                @if($request->root_cause)
                    <div class="w-100 mt-2 html-content" v-pre>
                        <h5 class="text-info">{{__('admin.root_cause')}}</h5>
                        {!! $request->root_cause !!}
                        <hr>
                    </div>
                @endif

                @if($request->attachments && count($request->attachments) > 0)
                    <div class="w-100 mt-2">
                        <h5 class="text-info">{{__('admin.attachment')}}</h5>
                        @foreach($request->attachments as $attachment)
                            <a target="_blank" class="attachment-box"
                               href="/requests/download-attachment/{{$id}}/{{$attachment['id']}}">
                                <i class="fa fa-file mr-1" aria-hidden="true"></i> {{$attachment['name']}}
                            </a>
                        @endforeach
                    </div>
                @endif
            </b-col>
            <b-col cols="12" xl="6">
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.request_type')}}</div>
                        <div class="cell text-left">
                            {{$request->type}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.status')}}</div>
                        <div class="cell text-left">
                            <b-badge variant="info"
                                     class="status-{{strtolower($request->status)}}">{{$request->status}}</b-badge>
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.mode')}}</div>
                        <div class="cell text-left">
                            {{$request->mode}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">TAC</div>
                        <div class="cell text-left">
                            {{$request->tac != '' ? $request->tac : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">SO</div>
                        <div class="cell text-left">
                            {{$request->so != '' ? $request->so : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.so_status')}}</div>
                        <div class="cell text-left">
                            {{$request->so_status != '' ? $request->so_status : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.start_date')}} (Open)</div>
                        <div class="cell text-left">
                            @if($request->active_date)
                                <span v-text="$moment('{{$request->active_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.due_by_date')}}</div>
                        <div class="cell text-left">
                            @if($request->due_by_date)
                                <span v-text="$moment('{{$request->due_by_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.last_reply')}}</div>
                        <div class="cell text-left">
                            @if($request->last_reply)
                                <span v-text="$moment('{{$request->last_reply}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.closed_date')}}</div>
                        <div class="cell text-left">
                            @if($request->closed_date)
                                <span v-text="$moment('{{$request->closed_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                {{--Response--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.response_time')}}
                            ({{__('admin.estimate')}})
                        </div>
                        <div class="cell text-left">
                            @if($request->response_time_estimate_datetime)
                                <span v-text="$moment('{{$request->response_time_estimate_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.response_time')}}</div>
                        <div class="cell text-left">
                            @if($request->response_time_datetime)
                                <span v-text="$moment('{{$request->response_time_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                                <span class="text-warning">[{{Tool::calcMinutesToDays($request->response_time)}}]</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_response')}}</div>
                        <div class="cell text-left">
                            {{Tool::calcMinutesToDays($request->response_time_late)}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_response_reason')}}</div>
                        <div class="cell text-left">
                            {{$request->late_response_reason != '' ? $request->late_response_reason : '-'}}
                        </div>
                    </div>
                </div>

                {{--Resolve--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.resolve_time')}}
                            ({{__('admin.estimate')}})
                        </div>
                        <div class="cell text-left">
                            @if($request->resolve_time_estimate_datetime)
                                <span v-text="$moment('{{$request->resolve_time_estimate_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.resolve_time')}}</div>
                        <div class="cell text-left">
                            @if($request->resolve_time_datetime)
                                <span v-text="$moment('{{$request->resolve_time_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                                <span class="text-warning">[{{Tool::calcMinutesToDays($request->resolve_time)}}]</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_resolve')}}</div>
                        <div class="cell text-left">
                            {{Tool::calcMinutesToDays($request->resolve_time_late)}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_resolve_reason')}}</div>
                        <div class="cell text-left">
                            {{$request->late_resolve_reason != '' ? $request->late_resolve_reason : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.last_update')}}</div>
                        <div class="cell text-left">
                            {{$request->last_update ?? ''}}
                        </div>
                    </div>
                </div>
            </b-col>
            <b-col cols="12" xl="6">
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.flag')}}</div>
                        <div class="cell text-left">
                            @if($request->flag == 1)
                                <b-icon icon="flag-fill" variant="danger"></b-icon>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.site')}}</div>
                        <div class="cell text-left">
                            {{Data::$sites[$request->site] ?? '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.category')}}</div>
                        <div class="cell text-left">
                            {{$request->category_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.sla')}}</div>
                        <div class="cell text-left">
                            {{$request->sla_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.priority')}}</div>
                        <div class="cell text-left">
                            <b-badge variant="info"
                                     class="status-lv{{strtolower($request->priority_level > 5 ? 5 : $request->priority_level)}}">{{$request->priority_name}}</b-badge>
                        </div>
                    </div>
                </div>

                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.customer_email')}}</div>
                        <div class="cell text-left">
                            <a href="/customers/customer/{{$request->client_id}}" class="text-normal">{{$request->client_email}}</a>
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.customer_company')}}</div>
                        <div class="cell text-left">{{$customer_company[$request->client_email] ?? ''}}</div>
                    </div>
                </div>

                {{--Technicians--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.company')}}</div>
                        <div class="cell text-left">
                            {{$request->company_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.group')}}</div>
                        <div class="cell text-left">
                            {{$request->group_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.technician')}}</div>
                        <div class="cell text-left">
                            <a href="/users/user/{{$technician->id}}" class="text-normal">{{$technician->name}}</a>
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.other_technicians')}}</div>
                        <div class="cell text-left">
                        </div>
                    </div>
                </div>

                {{--Requester--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.requested_by')}}</div>
                        <div class="cell text-left">
                            <a href="/users/user/{{$requester->id}}" class="text-normal">{{$requester->name}}</a>
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.followers')}}</div>
                        <div class="cell text-left">
                        </div>
                    </div>
                </div>

                {{--Device--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.part_device')}}</div>
                        <div class="cell text-left">
                            {{$request->part_device != '' ? $request->part_device : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.serial_number')}}</div>
                        <div class="cell text-left">
                            {{$request->serial_number != '' ? $request->serial_number : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.tracking_number')}}</div>
                        <div class="cell text-left">
                            {{$request->tracking_number != '' ? $request->tracking_number : '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.rma_doa')}}</div>
                        <div class="cell text-left">
                            {{$request->rma_doa != '' ? $request->rma_doa : '-'}}
                        </div>
                    </div>
                </div>
            </b-col>
        </b-row>
    </b-card-body>
</b-card>

<request-solutions
        :vars="{{json_encode(['type' => 'Request', 'id' => $id ,'solutions' => $solutions])}}">
</request-solutions>

<b-row>
    <b-col cols="12" class="mt-4">
        <h1 class="text-white mb-0">{{__('admin.replies')}}</h1>
    </b-col>
</b-row>
<request-replies :vars="{{json_encode(['type' => 'Request', 'id' => $id ,'object' => $request])}}"></request-replies>
