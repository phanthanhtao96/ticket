<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'action',
        'rel_id',
        'description',
        'old',
        'new'
    ];

    public function getOldAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setOldAttribute($value)
    {
        $this->attributes['old'] = json_encode($value);
    }

    public function getNewAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setNewAttribute($value)
    {
        $this->attributes['new'] = json_encode($value);
    }
}
