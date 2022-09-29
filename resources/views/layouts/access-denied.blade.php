@extends('main')
@section('title', __('admin.empty'))
@section('content')
    <b-alert variant="secondary" show>
        <b-icon icon="bell" variant="secondary"></b-icon> {{__('admin.access_denied')}}
    </b-alert>
@endsection