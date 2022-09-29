<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'type',
        'level',
        'name',
        'capabilities'
    ];

    public function getCapabilitiesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCapabilitiesAttribute($value)
    {
        $this->attributes['capabilities'] = json_encode($value);
    }

    public function currentCapabilities()
    {
        $roleId = Auth::user()->role_id;
        if (!Cache::has('capabilities_' . $roleId)) {
            $role = $this->find($roleId);
            $result = isset($role->capabilities) ? $role->capabilities : [];
            Cache::add('capabilities_' . $roleId, $result, Data::$cacheTime);
        } else {
            $result = Cache::get('capabilities_' . $roleId);
        }
        return $result;
    }
}
