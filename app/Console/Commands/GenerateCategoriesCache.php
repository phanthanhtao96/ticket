<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Data;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateCategoriesCache extends Command
{
    protected $signature = 'cron:generate_categories_cache';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $categoriesArr = [];
        $categories = Category::select(
            'id',
            'name'
        )
            ->get();
        foreach ($categories as $category) {
            $categoriesArr[$category->id]['name'] = $category->name;
        }

        Cache::put('categories_arr', $categoriesArr, Data::$cacheTime);
    }
}
