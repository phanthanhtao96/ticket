<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'technician',
        'level',
        'description'
    ];

    public function getDefaultGroup()
    {
        if (!Cache::has('default_group')) {
            $group = $this->orderBy('id', 'asc')->first();
            Cache::add('default_group', $group, Data::$cacheTime);
        } else {
            $group = Cache::get('default_group');
        }
        return $group;
    }
}