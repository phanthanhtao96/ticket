<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Exports\RequestsExport;
use App\Models\Company;
use App\Models\Data;
use App\Models\Priority;
use App\Models\SLA;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ReportsController extends Controller
{
    public function getReport()
    {
        $requestsTableColumn = [
            'type',
            'site',
            'mode',
            'so',
            'tac',
            'flag',
            'solutions',
            'technician_id',
            'client_id',
            'invoice_id',
            'category_id',
            'company_id',
            'client_email',
            'request_by',
            'sla_id',
            'priority_id',
            'status',
            'name',
            'active_date',
            'last_reply',
            'due_by_date',
            'resolved_date',
            'closed_date'
        ];

        $users = User::query()->pluck('name', 'id');
        $company = Company::query()->get();
        $sla = SLA::query()->get();
        $priority = Priority::query()->get();

        return view('layouts.report.report')->with([
            'requests_table_column' => $requestsTableColumn,
            'users' => $users,
            'company' => $company,
            'sla' => $sla,
            'priority' => $priority
        ]);
    }

    public function runReport(Request $request)
    {
        $columns = $request->columns ?? [];
        $dateRange = $request->date_range ?? 2; //requests.active_date
        $fromDate = $request->from_date ?? '';
        $fromTime = $request->from_time ?? '';
        $toDate = $request->to_date ?? '';
        $toTime = $request->to_time ?? '';
        $requestBy = $request->request_by ?? '';
        $technicianId = $request->technician_id ?? '';
        $status = $request->status ?? 'All';
        $overdueStatus = $request->overdue_status ?? 'All';
        $sortBy = $request->sort_by ?? 0; //requests.id
        $sortType = $request->sort_type ?? 'asc';
        $clientEmail = $request->client_email ?? '';
        $companyId = $request->company_id ?? '';
        $sla = $request->sla ?? '';
        $priorityId = $request->priority_id ?? '';
        $tacNumber = $request->tac_number ?? '';
        $requestId = $request->request_id ?? '';
        $subject = $request->subject ?? '';
        $columnSelectWithValues = $request->column_select_with_values ?? '';
        $selectWithValues = $request->select_with_values ?? '';

        $conditions = [];
        if ($fromDate != '' && $toDate != '') {
            $dateRangeColumn = Data::$requestReportFields[$dateRange]['columns'][0];
            $from = Carbon::parse($fromDate . ' ' . $fromTime)->format('Y-m-d H:i:00');
            $to = Carbon::parse($toDate . ' ' . $toTime)->format('Y-m-d 23:59:59');

            if (!empty($toTime)) {
                $to = Carbon::parse($toDate . ' ' . $toTime)->format('Y-m-d H:i:00');
            }

            $conditions[] = [$dateRangeColumn, '>=', $from];
            $conditions[] = [$dateRangeColumn, '<=', $to];
        }

        if (!empty($requestBy)) {
            $conditions[] = ['requests.request_by', $requestBy];
        }

        if (!empty($technicianId)) {
            $conditions[] = ['requests.technician_id', $technicianId];
        }

        if (!empty($clientEmail)) {
            $conditions[] = ['requests.client_email', 'LIKE', "%$clientEmail%"];
        }

        if (!empty($companyId)) {
            $conditions[] = ['requests.company_id', $companyId];
        }

        if (!empty($requestId)) {
            $conditions[] = ['requests.id', $requestId];
        }

        if (!empty($tacNumber)) {
            $conditions[] = ['requests.tac', $tacNumber];
        }


        if ($subject) {
            $conditions[] = ['requests.name', 'LIKE', "%$subject%"];
        }

        if (!empty($sla)) {
            $conditions[] = ['requests.technician_id', $sla];
        }

        if (!empty($priorityId)) {
            $conditions[] = ['requests.priority_id', $priorityId];
        }

        if ($overdueStatus != 'All') {
            $conditions[] = ['requests.overdue_status', $overdueStatus];
        }

        if ($columnSelectWithValues != '' && $selectWithValues != '') {
            $selectWithValuesColumn = Data::$requestReportFields[$columnSelectWithValues]['columns'][0];
            $conditions[] = [$selectWithValuesColumn, $selectWithValues];
        }

        $sortColumn = Data::$requestReportFields[$sortBy]['columns'][0];

        $reportData = ClientRequest::query()->leftJoin('clients', 'requests.client_id', 'clients.id')
            ->join('priorities', 'requests.priority_id', 'priorities.id')
            ->join('sla', 'requests.sla_id', 'sla.id')
            ->leftJoin('ratings', 'requests.id', 'ratings.request_id')
            ->join('companies', 'requests.company_id', 'companies.id')
            ->join('users as requester', 'requests.request_by', 'requester.id')
            ->join('users as assignee', 'requests.technician_id', 'assignee.id')
            ->select('requests.*',
                'sla.name as sla_name',
                'priorities.name as priorities_name',
                'clients.name as clients_name',
                'clients.email as clients_email',
                'clients.phone as clients_phone',
                'companies.name as companies_name',
                'requester.name as request_by',
                'assignee.name as technician_name',
                'ratings.rating1 as ratings_rating1',
                'ratings.rating2 as ratings_rating2',
                'ratings.rating3 as ratings_rating3',
                'ratings.rating4 as ratings_rating4',
                'ratings.response_rating as ratings_response_rating',
                DB::raw("(SELECT content FROM replies WHERE replies.rel_id = requests.id ORDER BY created_at DESC LIMIT 1) as reply_content")
            )
            ->where($conditions)
            ->orderBy($sortColumn, $sortType);

        if ($status != 'All') {
            $reportData->whereIn('requests.status', $status);
        }

        $reportData = $reportData->get();

        //return Excel::download(new RequestsExport($columns, $reportData), 'requests.xlsx');
        $userId = Auth::user()->id;
        Cache::add('report_columns_' . $userId, $columns, Data::$cacheTime);
        Cache::add('report_data_' . $userId, $reportData, Data::$cacheTime);
        return view('layouts.report.report-table')->with(['columns' => $columns, 'report_data' => $reportData]);
    }

    public function export()
    {
        $time = Carbon::now()->format('d-m-Y');
        $userId = Auth::user()->id;
        if (Cache::has('report_columns_' . $userId) && Cache::has('report_data_' . $userId))
            return Excel::download(new RequestsExport(Cache::get('report_columns_' . $userId), Cache::get('report_data_' . $userId)), 'SD-report-' . $time . '.xlsx');
    }

    public function periodicReports($fromDate, $toTime, $sortType)
    {
        $columns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
        $conditions = [];
        $conditions[] = ['requests.active_date', '>=', $fromDate];
        $conditions[] = ['requests.active_date', '<=', $toTime];

        $reportData = ClientRequest::join('clients', 'requests.client_id', 'clients.id')
            ->join('priorities', 'requests.priority_id', 'priorities.id')
            ->join('sla', 'requests.sla_id', 'sla.id')
            ->join('companies', 'requests.company_id', 'companies.id')
            ->select('requests.*',
                'sla.name as sla_name',
                'priorities.name as priorities_name',
                'clients.name as clients_name',
                'clients.email as clients_email',
                'clients.phone as clients_phone',
                'companies.name as companies_name'
            )
            ->where($conditions)
            ->orderBy('requests.active_date', $sortType)
            ->get();

        $name = 'Auto-report.xlsx';
        return Excel::store(new RequestsExport($columns, $reportData), $name, 'export') ? asset('uploads/exports/' . $name) : '';
    }
}
