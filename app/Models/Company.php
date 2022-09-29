<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    public function getDefaultCompany()
    {
        if (!Cache::has('default_company')) {
            $company = $this->orderBy('id', 'asc')->first();
            Cache::add('default_company', $company, Data::$cacheTime);
        } else {
            $company = Cache::get('default_company');
        }
        return $company;
    }
}
