@extends('main')
@section('title', __('admin.categories'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.categories')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/categories/category/0'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_category')}}
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
                    <div class="cell cw-160 cell-9">
                        {{__('admin.type')}}
                    </div>
                    <div class="cell cw-70 cell-7">
                    </div>
                </div>
                @foreach($categories as $category)
                    <div class="sbd-row">
                        <div class="cell">
                            {{$category->id}}
                        </div>
                        <div class="cell">
                            <a href="/categories/category/{{$category->id}}">
                                {{$category->name}}
                            </a>
                        </div>
                        <div class="cell cell-9">
                            {{$category->type}}
                        </div>
                        <div class="cell cell-7">
                            <a class="text-danger mr-2" onclick="return confirm('{{__('admin.are_you_sure')}}')"
                               href="/categories/del/{{$category->id}}" v-b-tooltip.hover
                               title="{{__('admin.delete')}}" style="vert-align: middle">
                                <b-icon icon="trash"></b-icon>
                            </a>
                            <a href="/categories/category/{{$category->id}}" v-b-tooltip.hover
                               title="{{__('admin.edit')}}" style="vert-align: middle">
                                <b-icon icon="pencil-square"></b-icon>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 mb-3 float-left">
                {{$categories->links()}}
            </div>
        </b-col>
    </b-row>
@endsection