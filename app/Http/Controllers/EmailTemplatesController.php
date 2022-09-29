<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplatesController extends Controller
{
    public function getEmailTemplates()
    {
        $emailTemplates = EmailTemplate::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.email-templates.email-templates')->with(['email_templates' => $emailTemplates]);
    }

    public function getEmailTemplate($id = 0)
    {
        $emailTemplate = EmailTemplate::find($id);
        return !$emailTemplate ? view('layouts.empty') :
            view('layouts.email-templates.email-template')->with(['id' => $id, 'email_template' => $emailTemplate]);
    }

    public function postEmailTemplate(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'name' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'subject' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'post_content' => ['required', 'max:20000', 'regex:' . Data::$vueRegex]
        ], [
            'type.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.security_regex'),
            'subject.regex' => __('validation.security_regex'),
            'post_content.regex' => __('validation.vue_regex')
        ]);

        $update = [
            'type' => $request->type ?? '',
            'name' => $request->name ?? '',
            'subject' => $request->subject ?? '',
            'content' => $request->post_content ?? ''
        ];

        $emailTemplate = new EmailTemplate();
        $result = $emailTemplate->where('id', $id)->update($update);

        return !$result ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->back()->with(['success' => __('admin.update_successful')]);
    }
}
