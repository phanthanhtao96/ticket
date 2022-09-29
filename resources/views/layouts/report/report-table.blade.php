@extends('main')
@section('title', __('admin.report'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.report_results')}}</h1>
        </b-col>
        <b-col cols="12" class="mt-3 text-right">
            <b-form action="/report/export" method="post">
                @csrf
                <b-button type="submit" variant="warning" class="border-0 mt-3">{{__('admin.export_excel')}}</b-button>
            </b-form>
        </b-col>
        <b-col cols="12" class="mt-3">
            <div class="report-table-wrap">
                <table>
                    <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th class="bg-light">{{Data::$requestReportFields[$column]['name']}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($report_data as $item)
                        <tr>
                            @foreach($columns as $column)
                                <td>
                                    @php
                                        foreach (Data::$requestReportFields[$column]['columns'] as $dataCol) {

                                            if(Data::$requestReportFields[$column]['table'] == 'requests') {
                                                $ex = explode('.', $dataCol);
                                                $dataCol = $ex[1];
                                            }

                                            if(count(Data::$requestReportFields[$column]['columns']) > 1) {
                                                echo $item[str_replace('.', '_', $dataCol)] . '<br>';
                                            } else {
                                                if($dataCol == 'root_cause' || $dataCol == 'content' || $dataCol == 'reply_content')
                                                    echo html_entity_decode($item[str_replace('.', '_', $dataCol)]);
                                                elseif ($dataCol == 'id')
                                                    echo Tool::getTicketNum($item[$dataCol]);
                                                else
                                                    echo $item[str_replace('.', '_', $dataCol)];
                                            }
                                        }
                                    @endphp
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </b-col>
    </b-row>
@endsection
