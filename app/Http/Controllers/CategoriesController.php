<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Data;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $categories = Category::orderBy('type', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(Data::$perPage);
        return view('layouts.categories.categories')->with(['categories' => $categories]);
    }

    public function getCategory($id = 0)
    {
        $category = (object)[
            'type' => '',
            'parent_id' => 0,
            'name' => '',
            'description' => ''
        ];
        if ($id != 0)
            $category = Category::where('id', $id)->first();
        return !$category ? view('layouts.empty') :
            view('layouts.categories.category')->with(['id' => $id, 'category' => $category]);
    }

    public function postCategory(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'type' => ['required', 'min:3', 'max:40', 'regex:' . Data::$cleanString],
            'name' => ['required', 'unique:categories,name,' . $id, 'min:3', 'max:100', 'regex:' . Data::$cleanString],
            'description' => ['sometimes', 'nullable', 'max:20000', 'regex:' . Data::$securityRegex]
        ], [
            'type.regex' => __('validation.clean_string'),
            'name.regex' => __('validation.clean_string'),
            'description.regex' => __('validation.security_regex')
        ]);

        $update = [
            'parent_id' => 0,
            'type' => $request->type ?? '',
            'name' => $request->name ?? '',
            'description' => $request->description ?? ''
        ];

        $category = new Category();
        $result = $category->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/categories/category/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function delCategory($id = 0)
    {
        Category::where('id', $id)->delete();
        return redirect()->to('/categories')->with(['success' => __('admin.delete_successful')]);
    }
}
