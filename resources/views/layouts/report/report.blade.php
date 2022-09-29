@extends('main')
@section('title', __('admin.report'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.report')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <request-report :vars="{{json_encode([
    'request_report_fields' => Data::$requestReportFields,
    'request_status' => Data::$requestStatus,
    'users' => $users,
    'company' => $company,
    'slas' => $sla,
    'priorities' => $priority,
    ])}}"></request-report>
        </b-col>
    </b-row>
@endsection
