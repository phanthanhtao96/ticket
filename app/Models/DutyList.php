<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyList extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'start',
        'end'
    ];

    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
}
