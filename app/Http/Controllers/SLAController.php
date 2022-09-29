<?php

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Data;
use App\Models\Priority;
use App\Models\SLA;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SLAController extends Controller
{
    public function getSLAList()
    {
        $sla_list = SLA::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.sla.sla-list')->with(['sla_list' => $sla_list]);
    }

    public function getSLA($id = 0, $option = '')
    {
        $sla = (object)[
            'priority_id' => 0,
            'name' => '',
            'description' => '',
            'max_response_time' => 0,
            'max_resolve_time' => 0,
            'enable_levels' => [],
            'time_to_l2' => 0,
            'time_to_l3' => 0,
            'time_to_l4' => 0,
            'l2_data' => [],
            'l3_data' => [],
            'l4_data' => []
        ];
        if ($id != 0)
            $sla = SLA::where('id', $id)->first();

        $priorities = Priority::orderBy('level', 'asc')->select('id', 'name', 'level')->get();
        $changes = Change::where([['type', 'SLA'], ['rel_id', $id]])
            ->orderBy('id', 'desc')->paginate(10);

        return !$sla ? view('layouts.empty') :
            view('layouts.sla.sla')->with([
                'option' => $option,
                'id' => $id,
                'sla' => $sla,
                'priorities' => $priorities,
                'changes' => $changes
            ]);
    }

    public function postSLA(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'priority_id' => ['required', 'numeric', 'min:1', 'max:50000'],
            'name' => ['required', 'unique:categories,name,' . $id, 'min:2', 'max:50', 'regex:' . Data::$cleanString],
            'description' => ['sometimes', 'nullable', 'max:20000', 'regex:' . Data::$securityRegex],
            'max_response_time' => ['required', 'numeric', 'min:0', 'max:100000'],
            'max_resolve_time' => ['required', 'numeric', 'min:0', 'max:100000'],
            'time_to_l2' => ['required', 'numeric', 'min:0', 'max:100000'],
            'time_to_l3' => ['required', 'numeric', 'min:0', 'max:100000'],
            'time_to_l4' => ['required', 'numeric', 'min:0', 'max:100000'],
        ], [
            'name.regex' => __('validation.clean_string'),
            'description.regex' => __('validation.security_regex')
        ]);

        $update = [
            'priority_id' => $request->priority_id ?? 0,
            'name' => $request->name ?? '',
            'description' => $request->description ?? '',
            'max_response_time' => $request->max_response_time ?? 0,
            'max_resolve_time' => $request->max_resolve_time ?? 0,
            'time_to_l2' => $request->time_to_l2 ?? 0,
            'time_to_l3' => $request->time_to_l3 ?? 0,
            'time_to_l4' => $request->time_to_l4 ?? 0,
            'enable_levels' => empty($request->enable_levels) ? [0] : array_merge([0], $request->enable_levels)
        ];

        if (!$id) {
            $update = array_merge($update, [
                'response_data' => [],
                'l2_data'       => [],
                'l3_data'       => [],
                'l4_data'       => []
            ]);
        }

        $sla = new SLA();
        $result = $sla->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/sla/edit/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function updateRule(Request $request)
    {
        $id = $request->id ?? 0;
        $sla = SLA::find($id);
        if (!$sla) return response()->json(['status' => false, 'message' => __('admin.please_save_sla_first_time')]);

        $validator = Validator::make($request->all(), [
            'data_column' => ['required', Rule::in(['response_data', 'l2_data', 'l3_data', 'l4_data'])],
            'level' => ['required', 'numeric', 'min:1', 'max:4'],
            'time_type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'difference_time' => ['required', 'numeric', 'min:0', 'max:100000'],
            'action' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'email_type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'role_type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString]
        ], [
            'time_type.regex' => __('validation.clean_string'),
            'email_type.regex' => __('validation.clean_string'),
            'action.regex' => __('validation.clean_string'),
            'role_type.regex' => __('validation.clean_string')
        ]);

        if ($validator->fails()) {
            $errors = Tool::errorString($validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errors,
            ]);
        }


        $dataColumn = $request->data_column ?? 'l2_data';
        $ruleId = $request->rule_id ?? '';

        //Get old array
        $data = $sla->$dataColumn;

        if ($ruleId == '') {
            $ruleId = Carbon::now()->format('YmdHis') . rand(1000, 9000);
            $oldData = [];
        } else {
            $oldData = $data[$ruleId];
        }

        $data[$ruleId] = [
            'level' => $request->level ?? 2,
            'time_type' => $request->time_type ?? '',
            'difference_time' => $request->difference_time ?? 0,
            'action' => $request->action ?? '',
            'email_type' => $request->email_type ?? '',
            'role_type' => $request->role_type ?? '',
            'cc' => $request->cc ?? []
        ];

        if ($data[$ruleId]['time_type'] == 'Equal') $data[$ruleId]['difference_time'] = 0;

        $result = SLA::where('id', $id)->update([
            $dataColumn => $data
        ]);

        if (!$result) return response()->json(['status' => false, 'message' => __('admin.failed')]);
        else {
            //Save change
            (new ChangesController())->addChange('SLA', '', $id, $oldData, $data[$ruleId], ['name' => $sla->name . ' - Rule ' . $data[$ruleId]['time_type'] . ' ' . $data[$ruleId]['difference_time'] . ' ' . $data[$ruleId]['email_type']]);
            return response()->json(['status' => true, 'message' => __('admin.update_successful')]);
        }
    }

    public function getRule($id, $column, $rule_id)
    {
        $data = [];
        $sla = SLA::find($id);
        if ($sla || in_array($column, ['l2_data', 'l3_data', 'l4_data'])) {
            if (isset($sla->$column[$rule_id])) $data = $sla->$column[$rule_id];
        }
        return response()->json($data);
    }

    public function deleteRule($id, $column, $rule_id)
    {
        $sla = SLA::find($id);
        if (!$sla || !in_array($column, ['response_data', 'l2_data', 'l3_data', 'l4_data'])) return response()->json(['status' => false, 'message' => __('admin.failed')]);

        $oldData = $sla->$column;
        unset($oldData[$rule_id]);

        $result = SLA::where('id', $id)->update([
            $column => $oldData
        ]);

        return !$result ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.update_successful')]);

    }

    public function getDataRules($id, $column)
    {
        $sla = SLA::find($id);
        if (!$sla || !in_array($column, ['response_data', 'l2_data', 'l3_data', 'l4_data'])) return response()->json([]);
        return response()->json($sla->$column);
    }

    public function calcOpenDateTimes($slaId, $startTime)
    {
        $result = [];
        $sla = SLA::find($slaId);
        if (!$sla || $sla->priority_id == 0) return [];
        $result['response_time_estimate'] = $sla->max_response_time;
        $result['response_time_estimate_datetime'] = Carbon::parse($startTime)->addMinutes($sla->max_response_time);
        $result['resolve_time_estimate'] = $sla->max_resolve_time;
        $result['resolve_time_estimate_datetime'] = Carbon::parse($startTime)->addMinutes($sla->max_resolve_time + 15);
        return $result;
    }

    public function calcFirstResponseDateTimes($slaId, $startTime, $responseDatetime)
    {
        $result = [];
        if (!$startTime) return [];
        $sla = SLA::find($slaId);
        if (!$sla) return [];

        $start = Carbon::parse($startTime);
        $end = Carbon::parse($responseDatetime);
        $responseAfterMinutes = $end->diffInMinutes($start);
        $result['response_time_datetime'] = $responseDatetime;
        $result['response_time'] = $responseAfterMinutes;
        //Late time
        $result['response_time_late'] = $responseAfterMinutes > $sla->max_response_time ? $responseAfterMinutes - $sla->max_response_time : 0;
        return $result;
    }

    public function calcCloseDateTimes($slaId, $startTime, $resolveDatetime)
    {
        $result = [];
        if (!$startTime) return [];
        $sla = SLA::find($slaId);
        if (!$sla) return [];

        $start = Carbon::parse($startTime);
        $end = Carbon::parse($resolveDatetime);
        $resolveAfterMinutes = $end->diffInMinutes($start);

        $result['resolve_time_datetime'] = $resolveDatetime;
        $result['resolve_time'] = $resolveAfterMinutes;
        //Late time
        $result['resolve_time_late'] = $resolveAfterMinutes > $sla->max_resolve_time ? $resolveAfterMinutes - $sla->max_resolve_time : 0;
        return $result;
    }
}
