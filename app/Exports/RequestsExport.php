<?php

namespace App\Exports;

use App\Models\Data;
use App\Models\Tool;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestsExport implements FromCollection,WithHeadings, WithChunkReading
{
    public $reportData;
    public $columns;
    public function __construct($columns, $reportData)
    {
        $this->columns = $columns;
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $data = [];
        foreach($this->reportData as $item){
            $datum = [];
            foreach($this->columns as $column){
                $datum[Data::$requestReportFields[$column]['key']] = '';
                foreach (Data::$requestReportFields[$column]['columns'] as $dataCol) {
                    if(Data::$requestReportFields[$column]['table'] == 'requests') {
                        $ex = explode('.', $dataCol);
                        $dataCol = $ex[1];
                    }

                    if(count(Data::$requestReportFields[$column]['columns']) > 1) {
                        $datum[Data::$requestReportFields[$column]['key']] .= $item[str_replace('.', '_', $dataCol)] . "-";
                    } else {
                        if($dataCol == 'root_cause'  || $dataCol == 'content' || $dataCol == 'reply_content')
                            $datum[Data::$requestReportFields[$column]['key']] = strip_tags(html_entity_decode($item[str_replace('.', '_', $dataCol)]));
                        elseif ($dataCol == 'id')
                            $datum[Data::$requestReportFields[$column]['key']] = Tool::getTicketNum($item[$dataCol]);
                        else
                            $datum[Data::$requestReportFields[$column]['key']] = $item[str_replace('.', '_', $dataCol)];
                    }
                }
            }

            if (!empty($datum)) {
                $data[] = $datum;
            }
        }

        return collect($data);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        $data = [];
        foreach($this->columns as $column){
            $data[] = Data::$requestReportFields[$column]['name'];
        }

        return $data;
    }
}
