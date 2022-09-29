<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Data;
use App\Models\User;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client;
use App\Models\SLA;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChangesController extends Controller
{
    public function getChanges()
    {
        $listInvoice = Invoice::query()->pluck('invoice_code', 'id')->toArray();
        $technicians = User::query()->pluck('name', 'id')->toArray();
        $companies   = Company::query()->pluck('name', 'id')->toArray();
        $groups      = Group::query()->pluck('name', 'id')->toArray();
        $clients     = Client::query()->pluck('name', 'id')->toArray();
        $sla         = SLA::query()->pluck('name', 'id')->toArray();
        $categories  = Category::query()->pluck('name', 'id')->toArray();
        $priorities  = Priority::query()->pluck('name', 'id')->toArray();
//        $rels        = Group::query()->pluck('name', 'id')->toArray();
        $changes = Change::orderBy('id', 'desc')->paginate(10);
        return view('layouts.changes.changes')->with([
            'changes' => $changes,
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

    public function addChange($type, $action, $relId, $oldData, $newData, $vars = [])
    {
        try {
            if ($action == 'Auto-Update')
                $user = (new User())->getDefaultUser();
            else
                $user = Auth::user();

            $dataLink = '';
            $actionText = 'Tự động cập nhật';
            $userLink = '<a href="/users/user/' . $user->id . '">' . $user->name . '</a>';

            if ($action == '') {
                if ($oldData) {
                    $action = 'Update';
                    $actionText = 'Đã cập nhật';
                } else {
                    $action = 'Create';
                    $actionText = 'Đã tạo mới';
                }
            }

            switch ($type):
                case 'Request':
                    $dataLink = '<a href="/requests/request/' . $relId . '">' . $newData['name'] . '</a>';
                    break;
                case 'Problem':
                    $dataLink = '<a href="/problems/problem/' . $relId . '">' . $newData['name'] . '</a>';
                    break;
                case 'SLA':
                    $dataLink = '<a href="/sla/edit/' . $relId . '">' . $vars['name'] . '</a>';
                    break;
            endswitch;

            //Fill value
            $oldData = json_encode($oldData);
            $oldData = json_decode($oldData, true);
            foreach ($oldData as $key => $value) {
                if (isset(Data::$cacheKeys[$key])) {
                    $oldData[$key] = Cache::get(Data::$cacheKeys[$key])[$value]['name'] ?? $value;
                }

                if ($key == 'site') {
                    $oldData[$key] = Data::$sites[$value] ?? $value;
                }

                if ($key == 'region') {
                    $oldData[$key] = Data::$regions[$value] ?? $value;
                }
            }

            foreach ($newData as $key => $value) {
                if (isset(Data::$cacheKeys[$key])) {
                    $newData[$key] = Cache::get(Data::$cacheKeys[$key])[$value]['name'] ?? $value;
                }

                if ($key == 'site') {
                    $newData[$key] = Data::$sites[$value] ?? $value;
                }

                if ($key == 'region') {
                    $newData[$key] = Data::$regions[$value] ?? $value;
                }
            }

            (new Change())->create([
                'user_id' => $user->id,
                'type' => $type,
                'action' => $action,
                'rel_id' => $relId,
                'description' => $userLink . ' ' . $actionText . ' ' . $dataLink,
                'old' => $oldData,
                'new' => $newData
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
