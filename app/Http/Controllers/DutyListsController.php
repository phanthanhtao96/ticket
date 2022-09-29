<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\DutyList;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DutyListsController extends Controller
{
    public function getDutyList()
    {
        $id = env('DUTY_LIST_ID', 1);
        $dutyList = DutyList::find($id);
        $lastDayOfMonth = Tool::lastDayOfCurrentMonth();
        return view('layouts.duty-list.duty-list')->with([
            'id' => $id,
            'duty_list' => $dutyList,
            'last_day_of_month' => $lastDayOfMonth,
            'current_month' => Carbon::now()->format('m/Y')
        ]);
    }

    public function postDutyList(Request $request)
    {
        $id = env('DUTY_LIST_ID', 1);
        $dutyList = [];

        foreach (Data::$daysInMonth as $day) {
            $dutyList[$day]['office_hours'] = isset($request[$day . '_office_hours']) && $request[$day . '_office_hours'] != '' ? explode(',', $request[$day . '_office_hours']) : [];
            $dutyList[$day]['outside_office_hours'] = isset($request[$day . '_outside_office_hours']) && $request[$day . '_outside_office_hours'] != '' ? explode(',', $request[$day . '_outside_office_hours']) : [];
            $dutyList[$day]['inside_outside_office_hours'] = isset($request[$day . '_inside_outside_office_hours']) && $request[$day . '_inside_outside_office_hours'] != '' ? explode(',', $request[$day . '_inside_outside_office_hours']) : [];
        }

        $result = DutyList::where('id', $id)->update([
            'data' => $dutyList
        ]);

        return !$result ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->back()->with(['success' => __('admin.update_successful')]);
    }
}
