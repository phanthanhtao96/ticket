<?php
/***SaoBacDauTelecom***/

namespace App\Http\Controllers;

use App\Models\RecentItem;
use Illuminate\Support\Facades\Auth;

class RecentItemsController extends Controller
{
    public function getRecentItems()
    {
        $userId = Auth::user()->id;
        $recentItems = RecentItem::where('user_id', $userId)
            ->orderBy('sort', 'desc')
            ->limit(15);
        return response()->json($recentItems);
    }

    public function updateRecentItem($type = '', $name = '', $route = '')
    {
        $userId = Auth::user()->id;
        $recentItem = new RecentItem();
        $result = $recentItem->updateOrCreate([
            'route' => $route,
            'user_id' => $userId
        ], [
            'type' => $type,
            'name' => $name
        ]);
        return !isset($result->id) ? response()->json(['status' => false, 'message' => __('admin.failed')]) :
            response()->json(['status' => true, 'message' => __('admin.success')]);
    }
}
