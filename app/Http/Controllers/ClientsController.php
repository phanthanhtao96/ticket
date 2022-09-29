<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ClientsController extends Controller
{
    public function getClients($filter = '', $filter_value = '')
    {
        if ($filter && $filter_value) {
            $filter_value = str_replace('+', ' ', $filter_value);
            $column = Schema::hasColumn('clients', $filter) ? $filter : 'name';
            if ($column == 'id') $conditions = [['id', $filter_value]];
            else $conditions = [[$column, 'LIKE', '%' . $filter_value . '%']];
        } else {
            $conditions = [];
        }

        $customers = Client::where($conditions)
            ->orderBy('id', 'desc')
            ->paginate(Data::$perPage);

        return view('layouts.clients.clients')
            ->with(
                [
                    'customers' => $customers,
                    'filter' => $filter,
                    'filter_value' => $filter_value
                ]);
    }

    public function postClients(Request $request)
    {
        $filter = $request->filter ?? 'name';
        $filter_value = $request->filter_value ?? '';
        $filter_value = str_replace(' ', '+', $filter_value);
        return redirect()->to('/customers/list/' . $filter . '/' . $filter_value);
    }

    public function getClient($id = 0)
    {
        $client = (object)[
            'type' => 'Normal',
            'email' => '',
            'name' => '',
            'company_name' => '',
            'phone' => '',
            'postcode' => '',
            'tax_code' => '',
            'identification_number' => '',
            'country' => '',
            'city' => '',
            'state' => '',
            'address' => '',
            'notes' => '',
            'disable' => 0
        ];
        if ($id != 0)
            $client = Client::where('id', $id)->first();
        return !$client ? view('layouts.empty') :
            view('layouts.clients.client')->with(['id' => $id, 'client' => $client]);
    }

    public function postClient(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'email' => ['required', 'email', 'min:8', 'max:50', 'unique:clients,email,' . $id, 'regex:' . Data::$cleanString],
            'name' => ['required', 'min:3', 'max:100', 'regex:' . Data::$cleanString],
            'company_name' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'phone' => ['required', 'min:10', 'max:15', 'regex:' . Data::$phoneRegex],
            'country' => ['required', 'min:2', 'max:40', 'regex:' . Data::$cleanString],
            'city' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'state' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'postcode' => ['required', 'numeric'],
            'address' => ['sometimes', 'nullable', 'max:500', 'regex:' . Data::$securityRegex],
            'notes' => ['sometimes', 'nullable', 'max:500', 'regex:' . Data::$securityRegex],
            'disable' => ['numeric', 'min:0', 'max:1']
        ], [
            'email.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.clean_string'),
            'company_name.regex' => __('validation.clean_string'),
            'type.regex' => __('validation.clean_string'),
            'phone.regex' => __('validation.phone_regex'),
            'country.regex' => __('validation.clean_string'),
            'city.regex' => __('validation.clean_string'),
            'state.regex' => __('validation.clean_string'),
            'address.regex' => __('validation.security_regex'),
            'notes.regex' => __('validation.security_regex'),
        ]);

        $update = [
            'type' => $request->type ?? 'Normal',
            'email' => $request->email ?? '',
            'name' => $request->name ?? '',
            'company_name' => $request->company_name ?? '',
            'phone' => $request->phone ?? '',
            'postcode' => '',
            'tax_code' => '',
            'identification_number' => '',
            'country' => $request->country ?? '',
            'city' => $request->city ?? '',
            'state' => $request->state ?? '',
            'address' => $request->address ?? '',
            'notes' => $request->notes ?? '',
            'disable' => $request->disable ?? 0
        ];

        $client = new Client();
        $result = $client->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/customers/customer/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function searchClientsJson($keyword = '')
    {
        return Client::where('disable', 0)
            ->where(function ($query) use ($keyword) {
                $query->where('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
            })
            ->select('id', 'email', 'name', 'phone')
            ->orderBy('name')
            ->limit(20)
            ->get();
    }
}
