<b-card no-body class="shadow-2">
    <template #header>
        <h2 class="mb-0">{{__('admin.view')}}</h2>
        <b-button variant="warning"
                  class="border-0 btn-sm text-white float-right ml-1"
                  onclick="window.location='/problems/problem/{{$id}}/edit'">
            <b-icon icon="pencil-fill"></b-icon>{{__('admin.edit')}}
        </b-button>
        <b-button variant="info"
                  class="border-0 btn-sm text-white float-right ml-1"
                  onclick="window.location='/problems/problem/{{$id}}/changes'">
            <b-icon icon="clock"></b-icon>{{__('admin.changes')}}
        </b-button>
    </template>
    <b-card-body>
        <b-row>
            <b-col cols="12" class="mb-4">
                <h1 class="text-warning"
                    class="mb-1">{{$problem->name}}</h1>
                <ul class="info-bar">
                    @if($problem->flag == 1)
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
                        {{$problem->due_by_date}}</li>
                    <li><label class="pr-1">{{__('admin.status')}}:</label>
                        {{$problem->status}}</li>
                    <li><label class="pr-1">{{__('admin.priority')}}:</label>
                        {{$problem->priority_name}}</li>
                </ul>
                <div class="hr-radius"></div>

                @if($problem->content)
                    <div class="w-100 mt-2 html-content" v-pre>
                        <h5 class="text-info">{{__('admin.content')}}</h5>
                        {!! $problem->content !!}
                        <hr>
                    </div>
                @endif

                @if($problem->root_cause)
                    <div class="w-100 mt-2 html-content" v-pre>
                        <h5 class="text-info">{{__('admin.root_cause')}}</h5>
                        {!! $problem->root_cause !!}
                        <hr>
                    </div>
                @endif

                @if($problem->attachments && count($problem->attachments) > 0)
                    <div class="w-100 mt-2">
                        <h5 class="text-info">{{__('admin.attachment')}}</h5>
                        @foreach($problem->attachments as $attachment)
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
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.status')}}</div>
                        <div class="cell text-left">
                            <b-badge variant="info"
                                     class="status-{{strtolower($problem->status)}}">{{$problem->status}}</b-badge>
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.start_date')}} (Open)</div>
                        <div class="cell text-left">
                            @if($problem->active_date)
                                <span v-text="$moment('{{$problem->active_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.due_by_date')}}</div>
                        <div class="cell text-left">
                            @if($problem->due_by_date)
                                <span v-text="$moment('{{$problem->due_by_date}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.last_reply')}}</div>
                        <div class="cell text-left">
                            @if($problem->last_reply)
                                <span v-text="$moment('{{$problem->last_reply}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.closed_date')}}</div>
                        <div class="cell text-left">
                            @if($problem->closed_date)
                                <span v-text="$moment('{{$problem->closed_date}}').format('HH:mm DD/MM/YYYY')"></span>
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
                            @if($problem->response_time_estimate_datetime)
                                <span v-text="$moment('{{$problem->response_time_estimate_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.response_time')}}</div>
                        <div class="cell text-left">
                            @if($problem->response_time_datetime)
                                <span v-text="$moment('{{$problem->response_time_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                                <span class="text-warning">[{{Tool::calcMinutesToDays($problem->response_time)}}]</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_response')}}</div>
                        <div class="cell text-left">
                            {{Tool::calcMinutesToDays($problem->response_time_late)}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_response_reason')}}</div>
                        <div class="cell text-left">
                            {{$problem->late_response_reason != '' ? $problem->late_response_reason : '-'}}
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
                            @if($problem->resolve_time_estimate_datetime)
                                <span v-text="$moment('{{$problem->resolve_time_estimate_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.resolve_time')}}</div>
                        <div class="cell text-left">
                            @if($problem->resolve_time_datetime)
                                <span v-text="$moment('{{$problem->resolve_time_datetime}}').format('HH:mm DD/MM/YYYY')"></span>
                                <span class="text-warning">[{{Tool::calcMinutesToDays($problem->resolve_time)}}]</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_resolve')}}</div>
                        <div class="cell text-left">
                            {{Tool::calcMinutesToDays($problem->resolve_time_late)}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.late_resolve_reason')}}</div>
                        <div class="cell text-left">
                            {{$problem->late_resolve_reason != '' ? $problem->late_resolve_reason : '-'}}
                        </div>
                    </div>
                </div>
            </b-col>
            <b-col cols="12" xl="6">
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.flag')}}</div>
                        <div class="cell text-left">
                            @if($problem->flag == 1)
                                <b-icon icon="flag-fill" variant="danger"></b-icon>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.site')}}</div>
                        <div class="cell text-left">
                            {{Data::$sites[$problem->site] ?? '-'}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.category')}}</div>
                        <div class="cell text-left">
                            {{$problem->category_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.sla')}}</div>
                        <div class="cell text-left">
                            {{$problem->sla_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.priority')}}</div>
                        <div class="cell text-left">
                            <b-badge variant="info"
                                     class="status-lv{{strtolower($problem->priority_level > 5 ? 5 : $problem->priority_level)}}">{{$problem->priority_name}}</b-badge>
                        </div>
                    </div>
                </div>

                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.customer_email')}}</div>
                        <div class="cell text-left">
                            {{$problem->client_email}}
                        </div>
                    </div>
                </div>

                {{--Technicians--}}
                <div class="sbd-table sbd-table-light mb-4">
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.company')}}</div>
                        <div class="cell text-left">
                            {{$problem->company_name}}
                        </div>
                    </div>
                    <div class="sbd-row">
                        <div class="cell cw-160 cell-7 text-muted bg-light">{{__('admin.group')}}</div>
                        <div class="cell text-left">
                            {{$problem->group_name}}
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

            </b-col>
        </b-row>
    </b-card-body>
</b-card>

<problem-requests
        :vars="{{json_encode(['id' => $id ,'requests' => $requests])}}">
</problem-requests>

<request-solutions
        :vars="{{json_encode(['type' => 'Problem', 'id' => $id ,'solutions' => $solutions])}}">
</request-solutions>

<b-row>
    <b-col cols="12" class="mt-4">
        <h1 class="text-white mb-0">{{__('admin.replies')}}</h1>
    </b-col>
</b-row>
<request-replies :vars="{{json_encode(['type' => 'Problem', 'id' => $id ,'object' => $problem])}}"></request-replies>