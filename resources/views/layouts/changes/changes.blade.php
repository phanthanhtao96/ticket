@extends('main')
@section('title', __('admin.changes'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.changes')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="sbd-table mb-5 shadow-2">
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
{{--                                                    @elseif(stripos($key, 'rel') !== false )--}}
{{--                                                        <span>{{(!empty($change->old[$key]) && !empty($rels[$change->old[$key]])) ? $rels[$change->old[$key]] : ''}}</span>--}}
{{--                                                        <b-icon icon="arrow-right"></b-icon>--}}
{{--                                                        <span class="text-success">{{$rels[$value]}}</span>--}}
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
            <div class="w-100 mb-3 float-left">
                {{$changes->links()}}
            </div>
        </b-col>
    </b-row>
@endsection
