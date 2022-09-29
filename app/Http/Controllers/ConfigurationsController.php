<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Data;
use Illuminate\Http\Request;

class ConfigurationsController extends Controller
{
    public function getDefaultConfigurations()
    {

        $officeHours = (new Configuration())->getConfiguration('office_hours');
        $workdays = (new Configuration())->getConfiguration('workdays');

        $officeHours = implode(',', (array)$officeHours);
        $workdays = implode(',', (array)$workdays);

        return view('layouts.configurations.configurations')->with([
            'office_hours' => $officeHours,
            'workdays' => $workdays
        ]);
    }

    public function postDefaultConfigurations(Request $request)
    {
        $request->validate([
            'office_hours' => ['sometimes', 'nullable', 'regex:' . Data::$cleanString],
            'workdays' => ['sometimes', 'nullable', 'regex:' . Data::$cleanString]
        ], [
            'office_hours.regex' => __('validation.clean_string'),
            'workdays.workdays' => __('validation.clean_string')
        ]);

        $officeHours = $request->office_hours ?? '';
        $workdays = $request->workdays ?? '';

        $officeHours = array_map('trim', explode(',', $officeHours));
        $workdays = array_map('trim', explode(',', $workdays));

        (new Configuration())->updateConfiguration('office_hours', 'Json', $officeHours);
        (new Configuration())->updateConfiguration('workdays', 'Json', $workdays);

        return redirect()->back()->with(['success' => __('admin.update_successful')]);
    }

    public function getReportConfigurations()
    {
        $weekdayAutoReport = (new Configuration())->getConfiguration('weekday_auto_report');
        $timeAutoReport = (new Configuration())->getConfiguration('time_auto_report');
        $toEmails = (new Configuration())->getConfiguration('auto_report_to_emails');

        return view('layouts.configurations.report')->with([
            'weekday_auto_report' => $weekdayAutoReport,
            'time_auto_report' => $timeAutoReport,
            'auto_report_to_emails' => $toEmails
        ]);
    }

    public function postReportConfigurations(Request $request)
    {
        $request->validate([
            'weekday_auto_report' => ['required', 'numeric', 'min:1', 'max:7'],
            'time_auto_report' => ['required', 'date_format:H:i'],
            'auto_report_to_emails' => ['sometimes', 'nullable', 'regex:' . Data::$cleanString]
        ], [
            'auto_report_to_emails.regex' => __('validation.clean_string')
        ]);

        $weekdayAutoReport = $request->weekday_auto_report ?? 1;
        $timeAutoReport = $request->time_auto_report ?? '00:00';

        $toEmails = $request->auto_report_to_emails ?? '';
        $toEmails = array_map('trim', explode(',', $toEmails));

        (new Configuration())->updateConfiguration('weekday_auto_report', 'Text', $weekdayAutoReport);
        (new Configuration())->updateConfiguration('time_auto_report', 'Text', $timeAutoReport);
        (new Configuration())->updateConfiguration('auto_report_to_emails', 'Json', $toEmails);

        return redirect()->back()->with(['success' => __('admin.update_successful')]);
    }
}
