<table>
    <thead>
    <tr>
        @foreach($columns as $column)
            <th><b>{{Data::$requestReportFields[$column]['name']}}</b></th>
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
                                if($dataCol == 'root_cause')
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