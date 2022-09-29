<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Img;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class ImagesController extends Controller
{
    public function getImages($select = '')
    {
        $images = Img::orderBy('id', 'desc')->paginate(Data::$perPage);
        return view('layouts.images')->with(['images' => $images, 'select' => $select]);
    }

    public function postImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|max:2048|image|mimes:jpg,jpeg,png,gif'
            ], [
                'file.required' => __('admin.file_required'),
                'file.image' => __('admin.file_image'),
                'file.mimes' => __('admin.file_mimes'),
                'file.max' => __('admin.file_max')
            ]);

            $image = $request->file('file');
            $folder = gmdate('Ym');
            if (!is_dir(public_path('uploads/original/') . $folder)) {
                @mkdir(public_path('uploads/original/') . $folder, 0777, true);
            }
            $newName = date("YmdHms") . '-' . rand(1000000, 9999999) . '.' . strtolower($image->getClientOriginalExtension());
            $fileUpload = $image->move(public_path('uploads/original/' . $folder), $newName);
            $this->resizeImage('uploads/200/' . $folder, $fileUpload, $newName, 200, null);
            $this->resizeImage('uploads/1200/' . $folder, $fileUpload, $newName, 1200, null);

            (new Img())->create([
                'user_id' => Auth::user()->id,
                'url' => $folder . '/' . $newName
            ]);
            return redirect()->back()->with(['success' => __('admin.upload_successful')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => $e->getMessage()]);
        }

    }

    public function resizeImage($folder, $fileUpload, $newName, $width, $height)
    {
        $img = Image::make($fileUpload);
        if (!is_dir(public_path($folder))) {
            @mkdir(public_path($folder), 0777, true);
        }
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        return $img->save(public_path($folder . '/') . $newName);
    }
}
