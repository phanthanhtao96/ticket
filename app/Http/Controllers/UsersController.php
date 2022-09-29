<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Data;
use App\Models\Department;
use App\Models\Group;
use App\Models\Role;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class UsersController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'min:8', 'max:50'],
            'password' => ['required', 'min:8', 'max:20']
        ]);

        $data = [
            'email' => $request->email ?? '',
            'password' => $request->password ?? ''
        ];

        if (Auth::attempt($data, true)) {

            //Check account disable
            if (Auth::user()->disable == 1) {
                Auth::logout();
                return redirect()->back()->with(['failed' => __('admin.the_account_has_been_disabled')]);
            }
            return redirect()->to('/');
        }
        return redirect()->back()->with(['failed' => __('admin.failed')]);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function msLogin()
    {
        $authUrl = 'https://login.microsoftonline.com/' . env('AZURE_TENANT_ID', '') . '/oauth2/v2.0/authorize';
        $query = http_build_query([
            'client_id' => env('AZURE_CLIENT_ID', ''),
            'client_secret' => env('AZURE_CLIENT_SECRET', ''),
            'response_type' => 'code',
            'redirect_uri' => secure_url('/ms-login-redirect'),
            'scope' => 'User.Read offline_access'
        ]);

        return redirect()->away($authUrl . '?' . $query);
    }

    public function msLoginRedirect(Request $request)
    {
        $authResponse = Http::asForm()->post('https://login.microsoftonline.com/' . env('AZURE_TENANT_ID', '') . '/oauth2/v2.0/token', [
            'client_id' => env('AZURE_CLIENT_ID', ''),
            'client_secret' => env('AZURE_CLIENT_SECRET', ''),
            'code' => $request->input('code'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => secure_url('/ms-login-redirect')
        ]);
        if (isset($authResponse['access_token']))
            $accessToken = $authResponse['access_token'];
        else
            return redirect('/');
        $user = Http::withToken($accessToken)->get('https://graph.microsoft.com/v1.0/me');
        $userInfo = is_array($user->json()) ? $user->json() : [];
        $user = User::where('email', $userInfo['mail'])->first();
        if (!$user) {

            $newUser = [
                'role_id' => 0,
                'company_id' => 0,
                'region' => '',
                'department_id' => 0,
                'groups' => [],
                'name' => $userInfo['displayName'] ?? '',
                'job_title' => $userInfo['jobTitle'] ?? '',
                'email' => $userInfo['mail'] ?? '',
                'password' => Hash::make(Tool::randomPassword(12)),
                'image' => '',
                'phone' => $userInfo['mobilePhone'] ?? '',
                'options' => [],
                'notes' => '',
                'disable' => 1
            ];
            (new User())->create($newUser);

            return redirect()->to('/login')->with(['failed' => __('admin.please_contact_your_administrator_to_enable_account')]);
        } else {
            Auth::login($user, true);
            //Check account disable
            if (Auth::user()->disable == 1) {
                Auth::logout();
                return redirect()->back()->with(['failed' => __('admin.the_account_has_been_disabled')]);
            }
            return redirect()->to('/')->with(['success' => __('admin.welcome') . ' ' . Auth::user()->name]);
        }
    }

    public function getUsers($filter = '', $filter_value = '')
    {
        if ($filter && $filter_value) {
            $filter_value = str_replace('+', ' ', $filter_value);
            $column = Schema::hasColumn('users', $filter) ? $filter : 'name';
            if ($column == 'id') $conditions = [['users.id', $filter_value]];
            else $conditions = [['users.' . $column, 'LIKE', '%' . $filter_value . '%']];
        } else {
            $conditions = [];
        }

        $companies = Company::query()->pluck('name', 'id');

        $users = User::where($conditions)
            ->orderBy('users.id', 'desc')
            ->paginate(Data::$perPage);

        return view('layouts.users.users')
            ->with(
                [
                    'users' => $users,
                    'filter' => $filter,
                    'companies' => $companies,
                    'filter_value' => $filter_value
                ]);
    }

    public function postUsers(Request $request)
    {
        $filter = $request->filter ?? 'name';
        $filter_value = $request->filter_value ?? '';
        $filter_value = str_replace(' ', '+', $filter_value);
        return redirect()->to('/users/list/' . $filter . '/' . $filter_value);
    }

    public function getUser($id = 0)
    {
        $user = (object)[
            'role_id' => 0,
            'company_id' => 0,
            'region' => '',
            'department_id' => 0,
            'groups' => [],
            'name' => '',
            'job_title' => '',
            'email' => '',
            'password' => '',
            'image' => '',
            'phone' => '',
            'options' => [],
            'notes' => '',
            'disable' => 0
        ];

        $companies = Company::orderBy('name', 'asc')->select('id', 'name')->get();
        $roles = Role::orderBy('id', 'asc')->select('id', 'name')->get();
        $departments = Department::orderBy('name', 'asc')->select('id', 'name')->get();
        $groups = Group::orderBy('name', 'asc')->select('id', 'name')->get();

        if ($id != 0)
            $user = User::where('id', $id)->first();
        return !$user ? view('layouts.empty') :
            view('layouts.users.user')->with([
                'id' => $id,
                'user' => $user,
                'companies' => $companies,
                'roles' => $roles,
                'departments' => $departments,
                'groups' => $groups
            ]);
    }

    public function postUser(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'role_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'company_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'department_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'region' => ['required', 'min:2', 'max:40', 'regex:' . Data::$cleanString],
            'email' => ['required', 'email', 'min:8', 'max:50', 'unique:users,email,' . $id],
            'password' => ['sometimes', 'nullable', 'confirmed', 'min:8', 'max:20', 'regex:' . Data::$passwordRegex],
            'password_confirmation' => ['sometimes', 'nullable', 'min:8', 'max:20'],
            'name' => ['required', 'min:3', 'max:100', 'regex:' . Data::$cleanString],
            'phone' => ['required', 'min:10', 'max:15', 'regex:' . Data::$phoneRegex],
            'disable' => ['numeric', 'min:0', 'max:1'],
            'notes' => ['sometimes', 'nullable', 'max:5000', 'regex:' . Data::$securityRegex]
        ], [
            'region' => __('validation.clean_string'),
            'password.regex' => __('validation.password_regex'),
            'name.regex' => __('validation.clean_string'),
            'phone.regex' => __('validation.phone_regex'),
            'notes.regex' => __('validation.security_regex')
        ]);

        $update = [
            'role_id' => $request->role_id ?? 0,
            'company_id' => $request->company_id ?? 0,
            'region' => $request->region ?? '',
            'department_id' => $request->department_id ?? 0,
            'groups' => $request->groups ?? [],
            'name' => $request->name ?? '',
            'job_title' => $request->job_title ?? '',
            'email' => $request->email ?? '',
            'image' => '',
            'phone' => $request->phone ?? '',
            'options' => [],
            'notes' => $request->notes ?? '',
            'disable' => $request->disable ?? 0
        ];

        $password = $request->password ?? '';
        $password ? $update['password'] = Hash::make($password) : null;

        $user = new User();
        $result = $user->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/users/user/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function getUsersJson($company_id = 0, $group_id = 0)
    {
        $conditions = [];
        if ($company_id != 0) $conditions[] = ['users.company_id', $company_id];
        if ($group_id != 0) $conditions[] = ['users.groups', 'LIKE', '%"' . $group_id . '"%'];

        $users = User::join('companies', 'users.company_id', 'companies.id')
            ->join('departments', 'users.department_id', 'departments.id')
            ->where($conditions)
            ->orderBy('users.name', 'asc')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.job_title',
                'companies.name as company_name',
                'departments.name as department_name')
            ->get();
        return response()->json($users);
    }

    public function getUserJson($id = 0)
    {
        $user = User::join('companies', 'users.company_id', 'companies.id')
            ->join('departments', 'users.department_id', 'departments.id')
            ->where('users.id', $id)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.job_title',
                'companies.name as company_name',
                'departments.name as department_name'
            )
            ->first();
        return response()->json($user);
    }

    public function searchUsersJson($keyword = '')
    {
        return User::where('disable', 0)
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
