<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Data;
use App\Models\Priority;
use Illuminate\Http\Request;

class PrioritiesController extends Controller
{
    public function getPriorities()
    {
        $priorities = Priority::orderBy('level', 'asc')->paginate();
        return view('layouts.priorities.priorities')->with(['priorities' => $priorities]);
    }

    public function getPriority($id = 0)
    {
        $priority = (object)[
            'id' => 0,
            'name' => '',
            'description' => '',
            'level' => 0
        ];
        if ($id != 0)
            $priority = Priority::where('id', $id)->first();
        return !$priority ? view('layouts.empty') :
            view('layouts.priorities.priority')->with(['id' => $id, 'priority' => $priority]);
    }

    public function postPriority(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'name' => ['required', 'unique:categories,name,' . $id, 'min:2', 'max:50', 'regex:' . Data::$cleanString],
            'level' => ['required', 'numeric', 'min:0', 'max:100', 'unique:priorities,level,' . $id],
            'description' => ['sometimes', 'nullable', 'max:20000', 'regex:' . Data::$securityRegex]
        ], [
            'name.regex' => __('validation.clean_string'),
            'description.regex' => __('validation.security_regex')
        ]);

        $update = [
            'name' => $request->name ?? '',
            'description' => $request->description ?? '',
            'level' => $request->level ?? 1
        ];

        $priority = new Priority();
        $result = $priority->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/priorities/priority/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }
}
