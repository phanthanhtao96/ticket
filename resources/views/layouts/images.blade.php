@extends('main')
@section('title', __('admin.images'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.images')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2 mb-3">
                <template #header>
                    <h2 class="mb-0">{{__('admin.images')}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/imgs" enctype="multipart/form-data">
                        <b-input-group prepend="{{__('admin.image')}}" class="mt-3">
                            <b-form-input id="txt" type="text" class="file"
                                          onclick="javascript:document.getElementById('u_button').click()"
                                          required></b-form-input>
                            <b-input-group-append>
                                <b-button type="button" variant="outline-light" id="u_button"
                                          onclick="javascript:document.getElementById('file').click()">...
                                </b-button>
                                <b-button type="submit" class="main-button">{{__('admin.upload')}}</b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="action" value="">
                        <input type="file" name="file" id="file" style="visibility: hidden"
                               onchange="ChangeText(this, 'txt')">
                    </b-form>
                </b-card-body>
            </b-card>
            <form name="frm-images">
                <div class="sbd-table mb-3 shadow-2 float-left">
                    <div class="sbd-row header">
                        <div class="cell cw-70">
                            ID
                        </div>
                        <div class="cell">
                        </div>
                        <div class="cell cw-50 cell-7">
                        </div>
                    </div>
                    @foreach($images as $image)
                        <div class="sbd-row">
                            <div class="cell">
                                {{$image->id}}
                            </div>
                            <div class="cell">
                                @if($select == 'select')
                                    <img src="/uploads/200/{{$image->url}}" class="img-large">
                                    <b-button type="button" variant="success" class="ml-3"
                                              onclick="javascript:document.getElementById('buttonSelect{{$image->id}}').click()">{{__('admin.select')}}</b-button>
                                    <input type="hidden" name="name_election_{{$image->id}}"
                                           value="{{$image->url}}"/>
                                    <input type="hidden" value="" id="buttonSelect{{$image->id}}"
                                           onclick="makeSelection(this.form, 'name_election_{{$image->id}}')">
                                @else
                                    <img src="/uploads/200/{{$image->url}}" class="img-large">
                                @endif
                            </div>
                            <div class="cell cell-7">
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
            <div class="w-100 mb-3 float-left">
                {{$images->links()}}
            </div>
        </b-col>
    </b-row>
@endsection
<script type="application/javascript" defer src="/js/libs/richtext/select-img-u.js"></script>