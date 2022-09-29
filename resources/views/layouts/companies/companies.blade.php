@extends('main')
@section('title', __('admin.companies'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.companies')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/companies/company'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_company')}}
            </b-button>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <div class="sbd-table mb-3 shadow-2 float-left">
                <div class="sbd-row header">
                    <div class="cell cw-70">
                        ID
                    </div>
                    <div class="cell">
                        {{__('admin.name')}}
                    </div>
                    <div class="cell cw-70 cell-7">
                    </div>
                </div>
                @foreach($companies as $company)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$company->id}}
                        </div>
                        <div class="cell">
                            <a href="/companies/company/{{$company->id}}">
                                {{$company->name}}
                            </a>
                        </div>
                        <div class="cell cell-7">
                            <a class="text-danger mr-2" onclick="return confirm('{{__('admin.are_you_sure')}}')"
                               href="/companies/del/{{$company->id}}" v-b-tooltip.hover
                               title="{{__('admin.delete')}}" style="vert-align: middle">
                                <b-icon icon="trash"></b-icon>
                            </a>
                            <a href="/companies/company/{{$company->id}}" v-b-tooltip.hover
                               title="{{__('admin.edit')}}" style="vert-align: middle">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$companies->links()}}
            </div>
        </b-col>
    </b-row>
@endsection