<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Data;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SolutionsController extends Controller
{
    public function getSolutions($filter = '', $filter_value = '')
    {
        if ($filter && $filter_value) {
            $filter_value = str_replace('+', ' ', $filter_value);
            $column = Schema::hasColumn('solutions', $filter) ? $filter : 'name';
            if ($column == 'id') $conditions = [['solutions.id', $filter_value]];
            else $conditions = [['solutions.' . $column, 'LIKE', '%' . $filter_value . '%']];
        } else {
            $conditions = [];
        }

        $solutions = Solution::join('categories', 'solutions.category_id', 'categories.id')
            ->where($conditions)
            ->select('solutions.*', 'categories.name as category_name')
            ->orderBy('solutions.id', 'desc')
            ->paginate(Data::$perPage);

        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();

        return view('layouts.solutions.solutions')
            ->with(
                [
                    'categories' => $categories,
                    'solutions' => $solutions,
                    'filter' => $filter,
                    'filter_value' => $filter_value
                ]);
    }

    public function postSolutions(Request $request)
    {
        $filter = $request->filter ?? 'name';
        $filter_value = $request->filter_value ?? '';
        $filter_value = str_replace(' ', '+', $filter_value);
        return redirect()->to('/solutions/list/' . $filter . '/' . $filter_value);
    }

    public function getSolution($id = 0, $option = '')
    {
        $solution = (object)[
            'user_id' => 0,
            'category_id' => 0,
            'flag' => 0,
            'name' => '',
            'content' => ''
        ];

        if ($id != 0)
            $solution = Solution::where('id', $id)->first();

        $categories = Category::where('type', 'Default')
            ->orderBy('name', 'ASC')
            ->get();

        if (!$solution) return view('layouts.empty');
        else {
            $solution->content = html_entity_decode($solution->content);
            return view('layouts.solutions.solution')->with([
                'id' => $id,
                'option' => $option,
                'categories' => $categories,
                'solution' => $solution
            ]);
        }
    }

    public function postSolution(Request $request)
    {
        $id = $request->id ?? 0;
        $request->validate([
            'category_id' => ['required', 'numeric', 'min:0', 'max:50000'],
            'flag' => ['numeric', 'min:0', 'max:1'],
            'name' => ['required', 'min:3', 'max:200', 'regex:' . Data::$cleanString],
            'post_content' => ['required', 'min:10', 'max:16777000']
        ], [
            'name.regex' => __('validation.clean_string')
        ]);

        $update = [
            'flag' => $request->flag ?? 0,
            'technician_id' => $request->technician_id ?? 0,
            'category_id' => $request->category_id ?? 0,
            'content' => htmlentities($request->post_content ?? ''),
            'name' => $request->name ?? ''
        ];
        if ($id == 0) $update['user_id'] = Auth::user()->id;

        $solution = new Solution();
        $result = $solution->updateOrCreate([
            'id' => $id
        ], $update);

        return !isset($result->id) ? redirect()->back()->with(['failed' => __('admin.failed')]) :
            redirect()->to('/solutions/solution/' . $result->id)->with(['success' => __('admin.update_successful')]);
    }

    public function searchSolutionsJson($keyword = '')
    {
        $solutions = Solution::where('name', 'LIKE', '%' . $keyword . '%')
            ->select('id', 'name')
            ->get();
        return response()->json($solutions);
    }
}
