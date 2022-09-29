@extends('main')
@section('title', __('admin.dashboard'))
@section('content')
    <b-row>
        <b-col md="12" lg="8" xl="9">
            <b-card no-body class="shadow-2 mb-4">
                <template #header>
                    <h2 class="mb-0">{{__('admin.control_panel')}}</h2>
                </template>
                <b-card-body>
                    <div class="icon-grid">
                        <div class="icon-wrap">
                            <a href="/requests/list">
                                <span class="icon-content">
                                    <i class="fa fa-ticket" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/requests/list">{{__('admin.requests')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/problems/list">
                                <span class="icon-content">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/problems/list">{{__('admin.problems')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/solutions/list">
                                <span class="icon-content">
                                    <i class="fa fa-compass" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/solutions/list">{{__('admin.knowledge')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/priorities/list">
                                <span class="icon-content">
                                    <i class="fa fa-thermometer-quarter" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/priorities/list">{{__('admin.priorities')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/sla/list">
                                <span class="icon-content">

                                    <i class="fa fa-certificate" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/sla/list">{{__('admin.sla')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/companies/list">
                                <span class="icon-content">
                                    <i class="fa fa-building-o" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/companies/list">{{__('admin.companies')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/categories/list">
                                <span class="icon-content">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/categories/list">{{__('admin.categories')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/report">
                                <span class="icon-content">
                                    <i class="fa fa-calculator" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/report">{{__('admin.report')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/users/list">
                                <span class="icon-content">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/users/list">{{__('admin.users')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/groups/list">
                                <span class="icon-content">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/groups/list">{{__('admin.groups')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/duty-list">
                                <span class="icon-content">
                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/duty-list">{{__('admin.duty_list')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/roles/list">
                                <span class="icon-content">
                                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/roles/list">{{__('admin.roles')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/users/list">
                                <span class="icon-content">
                                    <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/customers/list">{{__('admin.customers')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/changes/list">
                                <span class="icon-content">
                                    <i class="fa fa-history" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/changes/list">{{__('admin.changes')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/email-templates/list">
                                <span class="icon-content">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/email-templates/list">{{__('admin.email_templates')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/emails/sent-list">
                                <span class="icon-content">
                                    <i class="fa fa-reply-all" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/emails/sent-list">{{__('admin.email_sent_history')}}</a>
                        </div>
                        <div class="icon-wrap">
                            <a href="/configurations">
                                <span class="icon-content">
                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                </span>
                            </a>
                            <a href="/configurations">{{__('admin.configurations')}}</a>
                        </div>
                    </div>
                </b-card-body>
            </b-card>

            <div class="sbd-table shadow-2 mb-4">
                <div class="sbd-row header">
                    <div class="cell cw-50">ID</div>
                    <div class="cell text-left">
                        <b-icon icon="clock"></b-icon>
                    </div>
                </div>
                @foreach($changes as $change)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$change->id}}
                        </div>
                        <div class="cell text-left">
                            <p class="mb-0">
                                <b-icon icon="columns-gap"
                                        class="mr-1 {{$change->action == 'Auto-Update' ? 'text-danger' : ''}}"></b-icon>
                                <span class="text-muted mr-1"
                                      v-text="$moment('{{$change->created_at}}').format('HH:mm DD/MM/YYYY')"></span>
                                {!! $change->description !!}
                            </p>
                            @if(in_array($change->action, ['Update', 'Auto-Update']))
                                <ul class="mt-2">
                                    @foreach($change->new as $key => $value)
                                        @if($value != $change->old[$key])
                                            @if($key == 'content')
                                                <li class="text-warning">{{__('admin.the_content_has_changed')}}</li>
                                            @elseif($key == 'root_cause')
                                                <li class="text-info">{{__('admin.the_root_cause_has_changed')}}</li>
                                            @elseif($key == 'cc')
                                                <li>
                                                    <span class="text-muted mr-1">{{Tool::convertColumnLabel($key)}}
                                                        :</span>
                                                    @foreach($change->old[$key] as $oItem)
                                                        <span class="mr-1">{{$oItem}}</span>
                                                    @endforeach
                                                    <b-icon icon="arrow-right"></b-icon>
                                                    <span class="text-success">
                                                        @foreach($value as $item)
                                                            <span class="mr-1">{{$item}}</span>
                                                        @endforeach
                                                    </span>
                                                </li>
                                            @else
                                                <li>
                                                    <span class="text-muted mr-1">{{Tool::convertColumnLabel($key)}}
                                                        :</span>
                                                    @if (stripos($key, 'group') !== false)
                                                        <span>{{(!empty($change->old[$key]) && !empty($groups[$change->old[$key]])) ? $groups[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$groups[$value] ?? $value}}</span>
                                                    @elseif (stripos($key, 'company') !== false)
                                                        <span>{{(!empty($change->old[$key]) && !empty($companies[$change->old[$key]])) ? $companies[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$companies[$value] ?? $value}}</span>
                                                    @elseif(stripos($key, 'technician') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($technicians[$change->old[$key]])) ? $technicians[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$technicians[$value] ?? $value}}</span>
                                                    @elseif(stripos($key, 'invoice') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($listInvoice[$change->old[$key]])) ? $listInvoice[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$listInvoice[$value] ?? $value}}</span>
                                                    @elseif(stripos($key, 'client_id') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($clients[$change->old[$key]])) ? $clients[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{empty($clients[$value]) ? $value : $clients[$value]}}</span>
                                                    @elseif(stripos($key, 'category') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($categories[$change->old[$key]])) ? $categories[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$categories[$value] ?? $value}}</span>
                                                    @elseif(stripos($key, 'sla') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($sla[$change->old[$key]])) ? $sla[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$sla[$value] ?? $value}}</span>
                                                    @elseif(stripos($key, 'priority') !== false )
                                                        <span>{{(!empty($change->old[$key]) && !empty($priorities[$change->old[$key]])) ? $priorities[$change->old[$key]] : ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$priorities[$value] ?? $value}}</span>
                                                    @else
                                                        <span>{{$change->old[$key] ?? ''}}</span>
                                                        <b-icon icon="arrow-right"></b-icon>
                                                        <span class="text-success">{{$value}}</span>
                                                    @endif
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </b-col>
        <b-col md="12" lg="4" xl="3">
            <b-card no-body class="shadow-2 mb-4">
                <template #header>
                    <h2 class="mb-0">{{__('admin.processing')}}</h2>
                </template>
                <b-card-body>
                    <b-list-group>
                        @foreach($requests_in_processing as $request)
                            <b-list-group-item href="/requests/request/{{$request->id}}"
                                               class="flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{$request->name}}</h5>
                                    <b-badge pill variant="info"
                                             class="status-{{strtolower($request->status)}}">{{$request->status}}</b-badge>
                                </div>
                                <div class="rating-stars-box mt-2 mb-2">
                                    @if($request->active_date && $request->due_by_date)
                                        {!! Tool::generateTimeProgressBar($request->active_date, $request->due_by_date, '', 4) !!}
                                    @endif
                                </div>
                                <small class="text-muted">{{$request->client_email}}</small>
                            </b-list-group-item>
                        @endforeach
                    </b-list-group>
                </b-card-body>
            </b-card>
            <b-card no-body class="shadow-2 mb-4">
                <template #header>
                    <h2 class="mb-0">{{__('admin.customer_s_feedback')}}</h2>
                </template>
                <b-card-body>
                    <b-list-group>
                        @foreach($ratings as $rating)
                            <b-list-group-item href="/requests/request/{{$rating->request_id}}"
                                               class="flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{$rating->name}}</h5>
                                    <small class="text-muted">{{$rating->created_at}}</small>
                                </div>
                                <div class="rating-stars-box mt-2 mb-2">
                                    <b-form-rating id="rating-inline" inline value="{{$rating->rating}}"
                                                   readonly></b-form-rating>
                                </div>
                                <small class="text-muted">{{$rating->client_email}}</small>
                            </b-list-group-item>
                        @endforeach
                    </b-list-group>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection
