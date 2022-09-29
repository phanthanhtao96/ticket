<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Change;
use App\Models\Company;
use App\Models\Data;
use App\Models\Department;
use App\Models\Group;
use App\Models\Notification;
use App\Models\Priority;
use App\Models\Problem;
use App\Models\SLA;
use App\Models\Solution;
use App\Models\Tool;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ProblemsController extends Controller
{
    public function getProblems($filter = 'none', $filter_value = 'none', $status = '')
    {
        $conditions = [];
        if ($filter != 'none' && $filter_value != 'none') {
            $filter_value = str_replace('+', ' ', $filter_value);
            $column = Schema::hasColumn('problems', $filter) ? $filter : 'name';
            if ($column == 'id') $conditions = [['problems.id', $filter_value]];
            else $conditions = [['problems.' . $column, 'LIKE', '%' . $filter_value . '%']];
        }

        $problems = Problem::join('priorities', 'problems.priority_id', 'priorities.id')
            ->join('users', 'problems.request_by', 'users.id')
            ->join('users as tech', 'problems.technician_id', 'tech.id')
            ->where($conditions)
            ->when($status, function ($query, $status) {
                $statusArr = explode('+', $status);
                if ($status != '')
                    $query->whereIn('problems.status', $statusArr);
            })
            ->orderBy('problems.id', 'desc')
            ->select(
                'problems.*',
                'priorities.name as priority_name',
                'priorities.level as priority_level',
                'users.id as requester_id',
                'users.name as requester_name',
                'tech.id as technician_id',
                'tech.name as technician_name'
            )
            ->paginate(Data::$perPage);

        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();

        return view('layouts.problems.problems')
            ->with([
                'categories' => $categories,
                'problems' => $problems,
                'filter' => $filter,
                'filter_value' => $filter_value,
                'status' => $status
            ]);
    }

    public function postProblems(Request $request)
    {
        $filter = $request->filter ?? 'name';
        $filter_value = $request->filter_value ?? '';
        $filter_value = str_replace(' ', '+', $filter_value);
        $status = $request->status ?? '';
        return redirect()->to('/problems/list/' . $filter . '/' . $filter_value . '/' . $status);
    }

    public function getProblem($id = 0, $option = '')
    {
        $problem = (object)[
            'site' => '',
            'flag' => 0,
            'requests' => [],
            'solutions' => [],
            'technician_id' => 0,
            'company_id' => 0,
            'group_id' => 0,
            'category_id' => 0,
            'request_by' => 0,
            'priority_id' => '',
            'sla_id' => '',
            'status' => 'Open',
            'name' => '',
            'root_cause' => '',
            'content' => '',
            'attachments' => [],
            'hidden' => 0,
            'due_by_date' => null
        ];

        $technician = (object)[
            'id' => 0,
            'name' => '',
            'email' => '',
            'phone' => '',
            'job_title' => '',
            'company_name' => '',
            'department_name' => ''
        ];

        $requester = (object)[
            'id' => 0,
            'name' => '',
            'email' => '',
            'phone' => '',
            'job_title' => '',
            'company_name' => '',
            'department_name' => ''
        ];

        if ($id != 0)
            $problem = Problem::join('categories', 'problems.category_id', 'categories.id')
                ->join('companies', 'problems.company_id', 'companies.id')
                ->join('groups', 'problems.group_id', 'groups.id')
                ->join('priorities', 'problems.priority_id', 'priorities.id')
                ->join('sla', 'problems.sla_id', 'sla.id')
                ->select(
                    'problems.*',
                    'companies.name as company_name',
                    'groups.name as group_name',
                    'categories.name as category_name',
                    'priorities.name as priority_name',
                    'sla.name as sla_name'
                )
                ->where('problems.id', $id)->first();

        if ($problem->request_by != 0)
            $requester = User::join('companies', 'users.company_id', 'companies.id')
                ->join('departments', 'users.department_id', 'departments.id')
                ->where('users.id', $problem->request_by)
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

        if ($problem->technician_id != 0)
            $technician = User::join('companies', 'users.company_id', 'companies.id')
                ->join('departments', 'users.department_id', 'departments.id')
                ->where('users.id', $problem->technician_id)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.job_title',
                    'users.groups',
                    'companies.id as company_id',
                    'companies.name as company_name',
                    'departments.id as department_id',
                    'departments.name as department_name'
                )
                ->first();

        $departments = Department::orderBy('name', 'ASC')->select('id', 'name')->get();
        $companies = Company::orderBy('name', 'ASC')->select('id', 'name')->get();
        $groups = Group::orderBy('name', 'ASC')->get();
        $priorities = Priority::orderBy('level', 'ASC')->get();
        $slaList = SLA::orderBy('name', 'ASC')->get();
        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();
        $requests = \App\Models\Request::whereIn('id', $problem->requests)
            ->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->get();
        $solutions = Solution::whereIn('id', $problem->solutions)
            ->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->get();
        $changes = Change::where([['type', 'Problem'], ['rel_id', $id]])
            ->orderBy('id', 'desc')->paginate(10);

        if (!$problem) return view('layouts.empty');
        else {
            $problem->root_cause = html_entity_decode($problem->root_cause);
            $problem->content = html_entity_decode($problem->content);
            return view('layouts.problems.problem')->with([
                'id' => $id,
                'option' => $option,
                'problem' => $problem,
                'requester' => $requester,
                'technician' => $technician,
                'departments' => $departments,
                'companies' => $companies,
                'groups' => $groups,
                'sla_list' => $slaList,
                'priorities' => $priorities,
                'categories' => $categories,
                'requests' => $requests,
                'solutions' => $solutions,
                'changes' => $changes
            ]);
        }
    }

    public function postProblem(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'site' => ['required', 'min:2', 'max:40', 'regex:' . Data::$cleanString],
            'flag' => ['numeric', 'min:0', 'max:1'],
            'technician_id' => ['required', 'numeric'],
            'company_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'group_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'category_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'request_by' => ['required', 'numeric'],
            'sla_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'priority_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'status' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'name' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'root_cause' => ['sometimes', 'nullable', 'min:10', 'max:16777000'],
            'post_content' => ['required', 'min:10', 'max:16777000'],
            'hidden' => ['numeric', 'min:0', 'max:1'],

            'active_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'active_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'due_by_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'due_by_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'closed_date_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'closed_date_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'response_time_estimate_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'response_time_estimate_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'response_time_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'response_time_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'resolve_time_estimate_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'resolve_time_estimate_hm' => ['sometimes', 'nullable', 'date_format:H:i'],
            'resolve_time_ymd' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'resolve_time_hm' => ['sometimes', 'nullable', 'date_format:H:i'],

            'late_response_reason' => ['sometimes', 'nullable', 'max:5000'],
            'late_resolve_reason' => ['sometimes', 'nullable', 'max:5000'],
        ], [
            'site.regex' => __('validation.clean_string'),
            'status.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.clean_string')
        ]);

        $requestBy = $request->request_by ?? 0;
        if ($requestBy == 0) $requestBy = Auth::user()->id;

        $update = [
            'site' => $request->site ?? '',
            'flag' => $request->flag ?? 0,
            'company_id' => $request->company_id ?? 0,
            'group_id' => $request->group_id ?? 0,
            'technician_id' => $request->technician_id ?? 0,
            'category_id' => $request->category_id ?? 0,
            'request_by' => $requestBy,
            'sla_id' => $request->sla_id ?? 0,
            'priority_id' => $request->priority_id ?? 0,
            'status' => $request->status ?? 0,
            'name' => $request->name ?? '',
            'root_cause' => htmlentities($request->root_cause ?? ''),
            'content' => htmlentities($request->post_content ?? ''),
            'hidden' => $request->hidden ?? 0,

            'late_response_reason' => $request->late_response_reason ?? '',
            'late_resolve_reason' => $request->late_resolve_reason ?? '',
        ];

        $update = Tool::generatePostDateTime('due_by_date', 'due_by_date_ymd', 'due_by_date_hm', $request, $update);
        $update = Tool::generatePostDateTime('closed_date', 'closed_date_ymd', 'closed_date_hm', $request, $update);
        $update = Tool::generatePostDateTime('response_time_estimate_datetime', 'response_time_estimate_ymd', 'response_time_estimate_hm', $request, $update);
        $update = Tool::generatePostDateTime('response_time_datetime', 'response_time_ymd', 'response_time_hm', $request, $update);
        $update = Tool::generatePostDateTime('resolve_time_estimate_datetime', 'resolve_time_estimate_ymd', 'resolve_time_estimate_hm', $request, $update);
        $update = Tool::generatePostDateTime('resolve_time_datetime', 'resolve_time_ymd', 'resolve_time_hm', $request, $update);

        //Get old data for save change
        $oldData = [];
        if ($id != 0) {
            $oldData = Problem::where('id', $id)->first();
        }

        $problem = new Problem();
        $result = $problem->updateOrCreate([
            'id' => $id
        ], $update);

        if (!isset($result->id)) return redirect()->back()->with(['failed' => __('admin.failed')]);
        else {
            //Start calc time
            if (!isset($oldData['active_date']) && $result->status == 'Open') {
                $activeDate = Carbon::now();
                $calcTimes = (new SLAController())->calcOpenDateTimes($result->sla_id, $activeDate);
                if (isset($calcTimes['response_time_estimate_datetime']) && isset($calcTimes['resolve_time_estimate_datetime'])) {
                    $updateData = [
                        'active_date' => $activeDate,
                        'response_time_estimate_datetime' => $calcTimes['response_time_estimate_datetime'],
                        'resolve_time_estimate_datetime' => $calcTimes['resolve_time_estimate_datetime'],
                        'due_by_date' => $calcTimes['resolve_time_estimate_datetime']
                    ];
                    (new Problem())->where('id', $id)->update($updateData);
                }
            }

            //Notify to technician
            if (in_array($result->status, ['Open', 'Answered', 'CustomerReply']))
                $this->sendNotifyToTechnician($result->id, $result->name, $result->technician_id);

            //Save change
            (new ChangesController())->addChange('Problem', '', $result->id, $oldData, $update);
            return redirect()->to('/problems/problem/' . $result->id . '/edit')->with(['success' => __('admin.update_successful')]);
        }
    }

    private function sendNotifyToTechnician($problemId, $problemName, $technicianId)
    {
        $notifyCheck = Notification::where([
            ['type', 'Problem'],
            ['rel_id', $problemId],
            ['users', 'LIKE', '%"' . $technicianId . '"%']
        ])->first();
        $tech = (new User())->getUser($technicianId);
        if (!$notifyCheck && $tech) {

            (new NotificationsController())->addNotification(
                'Problem',
                1,
                $problemId,
                'Yêu cầu xủ lý: Problem #' . $problemId . ' ' . $problemName,
                env('APP_URL') . '/problems/problem/' . $problemId,
                [(string)$technicianId],
                [$tech->email ?? ''],
                'ProblemNotify',
                'assign-technical',
                ''
            );
        }

        return true;
    }

    public function addRequests(Request $request)
    {
        $id = $request->id ?? 0;
        $postRequests = $request->requests ?? [];

        $requestList = [];
        if (is_array($postRequests)) {
            foreach ($postRequests as $postRequest) {
                $requestList[] = (string)$postRequest['id'];
            }
        }

        $result = (new Problem())->where('id', $id)->update([
            'requests' => $requestList
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function removeRequest(Request $request)
    {
        $id = $request->id ?? 0;
        $postRequests = $request->requests ?? [];
        $removeId = $request->remove_id ?? 0;
        if (is_array($postRequests)) {
            $i = 0;
            foreach ($postRequests as $postRequest) {
                if ($removeId == $postRequest['id']) {
                    unset($postRequests[$i]);
                }
                $i++;
            }
        }
        $result = (new Problem())->where('id', $id)->update([
            'requests' => $postRequests
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function addSolutions(Request $request)
    {
        $id = $request->id ?? 0;
        $solutions = $request->solutions ?? [];

        $requestSolutions = [];
        if (is_array($solutions)) {
            foreach ($solutions as $solution) {
                $requestSolutions[] = (string)$solution['id'];
            }
        }

        $result = (new Problem())->where('id', $id)->update([
            'solutions' => $requestSolutions
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function removeSolution(Request $request)
    {
        $id = $request->id ?? 0;
        $solutions = $request->solutions ?? [];
        $removeId = $request->remove_id ?? 0;
        if (is_array($solutions)) {
            $i = 0;
            foreach ($solutions as $solution) {
                if ($removeId == $solution['id']) {
                    unset($solutions[$i]);
                }
                $i++;
            }
        }
        $result = (new Problem())->where('id', $id)->update([
            'solutions' => $solutions
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);
    }

    public function updateResponseTime($requestId, $responseUserId, $sentMail)
    {
        $now = Carbon::now();
        $update = [];
        $problem = Problem::find($requestId);
        if (!$problem) return null;

        if ($problem->response_time_datetime == null && $problem->technician_id == $responseUserId && $sentMail == 1) {
            $calcTimes = (new SLAController())->calcFirstResponseDateTimes($problem->sla_id, $problem->active_date, $now);
            if (isset($calcTimes['response_time_datetime'])) $update['response_time_datetime'] = $calcTimes['response_time_datetime'];
            if (isset($calcTimes['response_time'])) $update['response_time'] = $calcTimes['response_time'];
            if (isset($calcTimes['response_time_late'])) $update['response_time_late'] = $calcTimes['response_time_late'];
        }

        $update['status'] = 'Answered';
        $update['last_reply'] = $now;

        return (new Problem())->where('id', $requestId)->update($update);
    }
}
