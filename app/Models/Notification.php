<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'type',
        'priority',
        'rel_id',
        'description',
        'url',
        'users',
        'received'
    ];

    public function getUsersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setUsersAttribute($value)
    {
        $this->attributes['users'] = json_encode($value);
    }

    public function getReceivedAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setReceivedAttribute($value)
    {
        $this->attributes['received'] = json_encode($value);
    }
}
