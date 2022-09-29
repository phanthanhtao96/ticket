<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Data;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.companies.companies')->with(['companies' => $companies]);
    }

    public function getCompany($id = 0)
    {
        $company = (object)[
            'name' => '',
            'description' => '',
            'color' => ''
        ];
        if ($id != 0)
            $company = Company::where('id', $id)->first();
        return !$company ? view('layouts.empty') :
            view('layouts.companies.company')->with(['id' => $id, 'company' => $company]);
    }

    public function postCompany(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'name' => ['required', 'unique:companies,name,' . $id, 'min:3', 'max:100', 'regex:' . Data::$cleanString],
            'description' => ['sometimes', 'nullable', 'max:20000', 'regex:' . Data::$securityRegex]
        ], [
            'name.regex' => __('validation.clean_string'),
            'description.regex' => __('validation.security_regex')
        ]);

        $update = [
            'name' => $request->name ?? '',
            'description' => $request->description ?? '',
            'color' => $request->color ?? '#555555'
        ];

        $company = new Company();
        $result = $company->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/companies/company/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function delCompany($id = 0)
    {
        Company::where('id', $id)->delete();
        return redirect()->to('/companies')->with(['success' => __('admin.delete_successful')]);
    }
}
