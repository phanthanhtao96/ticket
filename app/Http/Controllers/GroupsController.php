<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function getGroups()
    {
        $groups = Group::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.groups.groups')->with(['groups' => $groups]);
    }

    public function getGroup($id = 0)
    {
        $group = (object)[
            'name' => '',
            'technician' => 0,
            'level' => 0,
            'description' => ''
        ];
        if ($id != 0)
            $group = Group::where('id', $id)->first();
        return !$group ? view('layouts.empty') :
            view('layouts.groups.group')->with(['id' => $id, 'group' => $group]);
    }

    public function postGroup(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'name' => ['required', 'unique:categories,name,' . $id, 'min:2', 'max:50', 'regex:' . Data::$cleanString],
            'level' => ['required', 'numeric', 'min:1', 'max:10', 'unique:groups,level,' . $id],
            'technician' => ['numeric', 'min:0', 'max:1'],
            'description' => ['sometimes', 'nullable', 'max:20000', 'regex:' . Data::$securityRegex]
        ], [
            'name.regex' => __('validation.clean_string'),
            'description.regex' => __('validation.security_regex')
        ]);

        $update = [
            'name' => $request->name ?? '',
            'technician' => $request->technician ?? 0,
            'description' => $request->description ?? '',
            'level' => $request->level ?? 1
        ];

        $group = new Group();
        $result = $group->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/groups/group/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }
}
