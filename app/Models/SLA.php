<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SLA extends Model
{
    use HasFactory;

    protected $table = 'sla';
    protected $fillable = [
        'priority_id',
        'name',
        'description',
        'max_response_time',
        'max_resolve_time',
        'enable_levels',
        'time_to_l2',
        'time_to_l3',
        'time_to_l4',
        'response_data',
        'l2_data',
        'l3_data',
        'l4_data'
    ];

    public function getEnableLevelsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setEnableLevelsAttribute($value)
    {
        $this->attributes['enable_levels'] = json_encode($value);
    }

    public function getResponseDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setResponseDataAttribute($value)
    {
        $this->attributes['response_data'] = json_encode($value);
    }

    public function getL2DataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setL2DataAttribute($value)
    {
        $this->attributes['l2_data'] = json_encode($value);
    }

    public function getL3DataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setL3DataAttribute($value)
    {
        $this->attributes['l3_data'] = json_encode($value);
    }

    public function getL4DataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setL4DataAttribute($value)
    {
        $this->attributes['l4_data'] = json_encode($value);
    }

    public function getDefaultSLA()
    {
        if (!Cache::has('default_sla')) {
            $priority = $this->orderBy('id', 'asc')->first();
            Cache::add('default_sla', $priority, Data::$cacheTime);
        } else {
            $priority = Cache::get('default_sla');
        }
        return $priority;
    }
}
