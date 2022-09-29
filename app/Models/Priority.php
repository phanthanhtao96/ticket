<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Priority extends Model
{
    use HasFactory;

    protected $table = 'priorities';
    protected $fillable = [
        'name',
        'description',
        'level'
    ];

    public function getDefaultPriority()
    {
        if (!Cache::has('default_priority')) {
            $urgency = $this->orderBy('level', 'asc')->first();
            Cache::add('default_priority', $urgency, Data::$cacheTime);
        } else {
            $urgency = Cache::get('default_priority');
        }
        return $urgency;
    }
}
