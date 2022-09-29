<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'data'
    ];

    public function getConfiguration($key)
    {
        if (!Cache::has('config_' . $key)) {
            $config = $this->where('key', $key)->first();
            if (!$config) $data = '';
            else {
                $data = $config->data;
                if ($config->data_type == 'Json') $data = json_decode($data, true);
            }
            Cache::add('config_' . $key, $data, Data::$cacheTime);
        } else {
            $data = Cache::get('config_' . $key);
        }
        return $data;
    }

    public function updateConfiguration($key, $dataType, $data)
    {
        if ($dataType == 'Json') $data = json_encode($data);
        $result = $this->where('key', $key)->update([
            'data' => $data
        ]);
        if ($result) Cache::forget('config_' . $key);
        return $result;
    }
}
