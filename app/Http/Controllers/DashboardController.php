<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Change;
use App\Models\Client;
use App\Models\Company;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Priority;
use App\Models\Rating;
use App\Models\Request as ClientRequest;
use App\Models\SLA;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $requestsInProcessing = ClientRequest::where([
            ['hidden', 0],
            ['active_date', '!=', null],
            ['due_by_date', '>', Carbon::now()]
        ])
            ->whereNotIn('status', ['Pending', 'Cancelled', 'Closed'])
            ->get();
        $changes = Change::orderBy('id', 'desc')->limit(10)->get();
        $listInvoice = Invoice::query()->pluck('invoice_code', 'id')->toArray();
        $technicians = User::query()->pluck('name', 'id')->toArray();
        $companies   = Company::query()->pluck('name', 'id')->toArray();
        $groups      = Group::query()->pluck('name', 'id')->toArray();
        $clients     = Client::query()->pluck('name', 'id')->toArray();
        $sla         = SLA::query()->pluck('name', 'id')->toArray();
        $categories  = Category::query()->pluck('name', 'id')->toArray();
        $priorities  = Priority::query()->pluck('name', 'id')->toArray();
        $ratings = Rating::join('requests', 'ratings.request_id', 'requests.id')
            ->select(
                'ratings.*',
                'requests.id as request_id',
                'requests.name',
                'requests.client_email'
            )
            ->limit(10)
            ->get();

        return view('layouts.dashboard')->with([
            'changes' => $changes,
            'requests_in_processing' => $requestsInProcessing,
            'ratings' => $ratings,
            'invoices' => $listInvoice,
            'technicians' => $technicians,
            'companies' => $companies,
            'groups' => $groups,
            'clients' => $clients,
            'sla' => $sla,
            'categories' => $categories,
            'priorities' => $priorities
        ]);
    }
}
