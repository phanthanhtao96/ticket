<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function getRoles()
    {
        $roles = Role::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.roles.roles')->with(['roles' => $roles]);
    }

    public function getRole($id = 0)
    {
        $role = (object)[
            'type' => 'Normal',
            'level' => 0,
            'name' => '',
            'capabilities' => []
        ];

        if ($id != 0)
            $role = Role::where('id', $id)->first();
        return !$role ? view('layouts.empty') :
            view('layouts.roles.role')->with(['id' => $id, 'role' => $role]);
    }

    public function postRole(Request $request)
    {
        $id = $request->id ?? 0;
        $capabilities = $request->capabilities ?? [];
        $request->validate([
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'level' => ['required', 'numeric', 'min:0', 'max:100', 'unique:roles,level,' . $id],
            'name' => ['required', 'min:3', 'max:40', 'unique:roles,name,' . $id, 'regex:' . Data::$cleanString],
            'capabilities' => ['sometimes', 'nullable'],
        ], [
            'type.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.clean_string')
        ]);
        $role = new Role();
        $name = $request->name ?? '';
        $data = [
            'name' => $name,
            'capabilities' => $capabilities
        ];
        $result = $role->updateOrCreate([
            'id' => $id
        ], $data);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/roles/role/' . $result->id)->with(['success' => __('admin.update_successful')]);

    }
}
