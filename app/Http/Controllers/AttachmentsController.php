<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttachmentsController extends Controller
{
    public function postAttachment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|max:20480|mimes:jpg,jpeg,png,gif,docx,xlsx,pdf'
            ], [
                'file.required' => __('admin.file_required'),
                'file.mimes' => __('admin.file_mimes'),
                'file.max' => __('admin.file_max')
            ]);

            if ($validator->fails()) {
                $errors = Tool::errorString($validator->errors()->all());
                return response()->json([
                    'status' => false,
                    'message' => $errors,
                ]);
            }
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();

            $folder = gmdate('Ym');
            if (!is_dir(public_path('uploads/original/') . $folder)) {
                @mkdir(public_path('uploads/original/') . $folder, 0777, true);
            }
            $newName = date("YmdHms") . '-' . rand(1000000, 9999999) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move(public_path('uploads/attachments/' . $folder), $newName);

            return response()->json([
                'status' => true,
                'message' => __('admin.upload_successful'),
                'name' => $originalName,
                'url' => asset('uploads/attachments/' . $folder) . '/' . $newName
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
