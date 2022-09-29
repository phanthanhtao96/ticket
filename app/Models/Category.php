<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'type',
        'parent_id',
        'name',
        'description'
    ];

    public function getDefaultCategory()
    {
        if (!Cache::has('default_category')) {
            $category = $this->orderBy('id', 'asc')->first();
            Cache::add('default_category', $category, Data::$cacheTime);
        } else {
            $category = Cache::get('default_category');
        }
        return $category;
    }
}
