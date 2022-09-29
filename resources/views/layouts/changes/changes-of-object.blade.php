<div class="sbd-table mb-5 shadow-2">
    <div class="sbd-row header">
        <div class="cell cw-50">ID</div>
        <div class="cell cell-has-button">
            <a href="{{$view_link}}">
                <b-icon icon="arrow-right" class="mr-2" style="vertical-align: auto"></b-icon>{{__('admin.back')}}</a>
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
                                        <span class="text-muted mr-1">{{Tool::convertColumnLabel($key)}}:</span>
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
                                        <span class="text-muted mr-1">{{Tool::convertColumnLabel($key)}}:</span>
                                        <span>{{$change->old[$key] ?? ''}}</span>
                                        <b-icon icon="arrow-right"></b-icon>
                                        <span class="text-success">{{$value}}</span>
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